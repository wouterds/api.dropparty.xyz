import static Constants.*

class Constants {
  static final REPO = 'internal-dropparty-api'
  static final DOCKER_FOLDER = '~/docker/projects/' + REPO
  static final SERVER = 'server03.wouterdeschuyter.be'
}

node {
  try {
    stage('Checkout') {
      sh 'printenv'
      checkout scm
    }

    stage('Clean') {
      sh 'make clean'
    }

    stage('Dependencies') {
      sh 'make vendor'
    }

    stage('Build') {
      sh 'make build'
    }

    stage('Deploy') {
      if (!env.BRANCH_NAME.equals('master') && !env.BRANCH_NAME.equals('develop')) {
        sh 'echo Not master or develop branch, skip deploy.'
        return
      }

      if (env.BRANCH_NAME.equals('develop')) {
        sh 'echo Deploying staging'
        deployStaging();
      }
    }
  } catch (e) {
    throw e
  } finally {
    // Clean up
    cleanWorkspace()
  }
}

def deployStaging() {
  sh 'make push-latest'

  def folder = DOCKER_FOLDER + '-stag';

  sh 'ssh wouterds@'+SERVER+' "mkdir -p '+folder+'"'
  sh 'ssh wouterds@'+SERVER+' "mkdir -p '+folder+'/logs && chmod 777 '+folder+'/logs"'

  sh 'scp docker/docker-compose.stag.yml wouterds@'+SERVER+':'+folder+'/docker-compose.yml'

  sh 'ssh wouterds@'+SERVER+' "cd '+folder+'; docker-compose pull"'
  sh 'ssh wouterds@'+SERVER+' "cd '+folder+'; docker-compose up -d"'

  sh 'ssh wouterds@'+SERVER+' "docker exec internaldroppartyapistag_php-fpm_1 php ./composer.phar migrations:migrate"'
}

def cleanWorkspace() {
  sh 'echo "Cleaning up workspace.."'
  deleteDir()
}
