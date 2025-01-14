const express = require('express');
const swaggerUi = require('swagger-ui-express');
const swaggerDocument = require('./swagger.json');
const pool = require('./config/database');
const search = require('./src/routes/search');
const statistic = require('./src/routes/statistic');

// Declarando variaveis 
const app = express();
const port = 3000;

// Middleware para JSON
app.use(express.json());

// Swagger
app.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerDocument));

// Rotas
app.use('/search', search);
app.use('/statistic', statistic);

// Conectando ao banco de dados e iniciando o servidor
pool.connect()
  .then(() => {
    console.log('Conectado ao PostgreSQL');
    app.listen(port, () => {
      console.log(`Servidor rodando na porta ${port}`);
    });
  })
  .catch((err) => {
    console.error('Erro ao conectar ao PostgreSQL:', err.stack);
  });
