pipeline {
    agent any

    stages {
        stage('Clone') {
            steps {
                timeout(time: 2, unit: 'MINUTES') {
                    git branch: 'main', credentialsId: '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', url: 'https://github.com/olger856/bolsa.git'
                }
            }
        }
        stage('Install Dependencies') {
            steps {
                timeout(time: 8, unit: 'MINUTES') {
                    // Ahora puedes ejecutar composer directamente
                    bat 'composer install'
                }
            }
        }
        stage('Run Tests') {
            steps {
                timeout(time: 8, unit: 'MINUTES') {
                    bat "php artisan test"
                }
            }
        }
        stage('Sonar') {
            steps {
                timeout(time: 4, unit: 'MINUTES') {
                    withSonarQubeEnv('sonarqube') {
                        bat """
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
                
                // Instalar dependencias en modo producción
                bat 'composer install --no-dev --optimize-autoloader'
                
                // Ejecutar migraciones de la base de datos
                bat "php artisan migrate --force"
                
                // Poblar la base de datos si es necesario
                bat "php artisan db:seed --force"
                
                // Optimización para producción
                bat "php artisan config:cache"
                bat "php artisan route:cache"
                bat "php artisan view:cache"
                
                // Reiniciar servicios (ejemplo con IIS)
                bat "iisreset"
            }
        }
    }
}
