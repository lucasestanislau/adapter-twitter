const knex = require("knex");
const configuration = require("../../knexfile");

const config = configuration.staging;

const connection = knex(config);

module.exports = connection;
