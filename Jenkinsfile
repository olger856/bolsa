pipeline {
    agent any

    environment {
        GIT_CREDENTIALS_ID = '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'
        SONARQUBE_TOKEN = credentials('SONARQUBE_TOKEN')
        SONARQUBE_URL = 'http://localhost:9000'
        DB_HOST = 'mysql_jenkins'  // Usamos el servicio MySQL dentro de Docker
    }

    stages {
        stage('Prepare Workspace') {
            steps {
                // Eliminar el archivo .env si existe antes del checkout
                sh 'rm -f /var/jenkins_home/workspace/Bolsa-pipe/.env || true'
            }
        }

        stage('Checkout') {
            steps {
                // Ejecuta el checkout
                checkout scm
            }
        }

        stage('Install Dependencies') {
            steps {
                timeout(time: 10, unit: 'MINUTES') {
                    sh 'composer install'
                    sh 'php artisan key:generate'
                }
            }
        }

        stage('Run Tests') {
            steps {
                timeout(time: 10, unit: 'MINUTES') {
                    // Ejecutar migraciones, seeders y tests
                    try {
                        sh 'php artisan migrate --force'
                        sh 'php artisan db:seed --force'
                        sh 'php artisan test'
                    } catch (Exception e) {
                        echo "Error al correr las migraciones o los tests: ${e}"
                        error "Failed during Run Tests stage"
                    }
                }
            }
        }

        stage('Sonar Analysis') {
            steps {
                timeout(time: 6, unit: 'MINUTES') {
                    withSonarQubeEnv('sonarqube') {
                        sh """
                        sonar-scanner \
                        -Dsonar.projectKey=bolsa \
                        -Dsonar.sources=app,resources,routes \
                        -Dsonar.exclusions=vendor/**,node_modules/** \
                        -Dsonar.host.url=${SONARQUBE_URL} \
                        -Dsonar.login=${SONARQUBE_TOKEN}
                        """
                    }
                }
            }
        }

        stage('Quality Gate') {
            steps {
                sleep(10)
                timeout(time: 2, unit: 'MINUTES') {
                    waitForQualityGate abortPipeline: true
                }
            }
        }

        stage('Deploy') {
            steps {
                echo "Despliegue del proyecto Laravel 'bolsa'."
                
                sh 'composer install --no-dev --optimize-autoloader'
                sh 'php artisan migrate --force'
                sh 'php artisan db:seed --force'
                sh 'php artisan config:cache'
                sh 'php artisan route:cache'
                sh 'php artisan view:cache'
            }
        }
    }

    post {
        failure {
            echo "El pipeline ha fallado. Revisa los logs para más detalles."
        }
        success {
            echo "El pipeline ha finalizado correctamente."
        }
    }

    options {
        buildDiscarder(logRotator(numToKeepStr: '10'))
    }
}
