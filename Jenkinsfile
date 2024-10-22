pipeline {
    agent any

    tools {
        // Define Composer como herramienta si está configurado en Jenkins.
    }

    stages {
        stage('Clone') {
            steps {
                timeout(time: 2, unit: 'MINUTES') {
                    git branch: 'main', credentialsId: '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', url:'https://github.com/olger856/bolsa.git'
                }
            }
        }
        stage('Install Dependencies') {
            steps {
                timeout(time: 8, unit: 'MINUTES') {
                    sh "composer install"
                }
            }
        }
        stage('Run Tests') {
            steps {
                timeout(time: 8, unit: 'MINUTES') {
                    sh "php artisan test"
                }
            }
        }
        stage('Sonar') {
            steps {
                timeout(time: 4, unit: 'MINUTES') {
                    withSonarQubeEnv('sonarqube') {
                        sh """
                        sonar-scanner \
                        -Dsonar.projectKey=bolsa \
                        -Dsonar.sources=app,resources,routes \
                        -Dsonar.exclusions=vendor/**,node_modules/** \
                        -Dsonar.host.url=\${SONAR_HOST_URL} \
                        -Dsonar.login=\${SONAR_TOKEN}
                        """
                    }
                }
            }
        }
        stage('Quality gate') {
            steps {
                sleep(10) // Espera unos segundos para que se procese el Quality Gate
                timeout(time: 2, unit: 'MINUTES') {
                    waitForQualityGate abortPipeline: true
                }
            }
        }
        stage('Deploy') {
            steps {
                echo "Despliegue del proyecto Laravel 'bolsa'."
                // Aquí puedes añadir comandos de despliegue de Laravel, como:
                // sh "php artisan migrate --force"
            }
        }
    }
}
