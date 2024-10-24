pipeline {
    agent any

    environment {
        GIT_CREDENTIALS_ID = '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'
        SONARQUBE_TOKEN = credentials('SONARQUBE_TOKEN')
        SONARQUBE_URL = 'http://localhost:9000'
        DB_HOST = 'mysql_jenkins'  // Usamos el servicio MySQL dentro de Docker
    }

    stages {
        stage('Clone') {
            steps {
                timeout(time: 2, unit: 'MINUTES') {
                    // Intentamos eliminar el archivo .env antes del checkout
                    sh 'rm -f /var/jenkins_home/workspace/Bolsa-pipe/.env || true'
                    git branch: 'main', credentialsId: GIT_CREDENTIALS_ID, url: 'https://github.com/olger856/bolsa.git'
                }
            }
        }

        stage('Checkout') {
            steps {
                script {
                    try {
                        checkout scm
                    } catch (Exception e) {
                        echo "Error during checkout: ${e}"
                        error "Stopping pipeline due to checkout failure"
                    }
                }
            }
        }

        stage('Install Dependencies') {
            steps {
                timeout(time: 8, unit: 'MINUTES') {
                    sh 'composer install'
                    echo 'analizar'
                    sh 'cp .env.d .env'
                    sh 'php artisan key:generate'
                }
            }
        }

        stage('Run Tests') {
            steps {
                timeout(time: 8, unit: 'MINUTES') {
                    // Ejecutar migraciones y seeders antes de los tests
                    sh 'sleep 10'  // Añadir una espera para asegurarse de que MySQL esté listo
                    sh 'php artisan migrate --force'
                    sh 'php artisan db:seed --force'
                    sh 'php artisan test'
                }
            }
        }

        stage('Sonar Analysis') {
            steps {
                timeout(time: 4, unit: 'MINUTES') {
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

    options {
        buildDiscarder(logRotator(numToKeepStr: '10'))
    }
}
