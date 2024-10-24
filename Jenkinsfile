pipeline {
    agent any

    environment {
        GIT_CREDENTIALS_ID = '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'
        SONARQUBE_TOKEN = credentials('SONARQUBE_TOKEN')  // Token seguro almacenado en Jenkins
        SONARQUBE_URL = 'http://localhost:9000'  // URL de SonarQube
    }

    stages {
        stage('Clone') {
            steps {
                timeout(time: 2, unit: 'MINUTES') {
                    git branch: 'main', credentialsId: GIT_CREDENTIALS_ID, url: 'https://github.com/olger856/bolsa.git'
                }
            }
        }
        
        stage('Install Dependencies') {
            steps {
                timeout(time: 8, unit: 'MINUTES') {
                    // Cambiar de 'bat' a 'sh' para entornos Linux
                    sh 'composer install'
                }
            }
        }

        stage('Run Tests') {
            steps {
                timeout(time: 8, unit: 'MINUTES') {
                    // Cambiar de 'bat' a 'sh'
                    sh "php artisan test"
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
                sleep(10) // Esperar unos segundos para que se procese el Quality Gate
                timeout(time: 2, unit: 'MINUTES') {
                    waitForQualityGate abortPipeline: true
                }
            }
        }

        stage('Deploy') {
            steps {
                echo "Despliegue del proyecto Laravel 'bolsa'."
                
                // Instalar dependencias en modo producción (cambiar a 'sh')
                sh 'composer install --no-dev --optimize-autoloader'
                
                // Ejecutar migraciones de la base de datos (cambiar a 'sh')
                sh "php artisan migrate --force"
                
                // Poblar la base de datos si es necesario (cambiar a 'sh')
                sh "php artisan db:seed --force"
                
                // Optimización para producción (cambiar a 'sh')
                sh "php artisan config:cache"
                sh "php artisan route:cache"
                sh "php artisan view:cache"
                
                // Si usas algún servidor como Nginx, puedes reiniciarlo con un comando de shell
                // sh "sudo service nginx reload" (dependiendo del servidor que uses)
            }
        }
    }

    options {
        buildDiscarder(logRotator(numToKeepStr: '10'))
    }
}
