const knex = require("knex");
const configuration = require("../../knexfile");

const config = configuration.staging;

const conexao = knex(config);

module.exports = conexao;
