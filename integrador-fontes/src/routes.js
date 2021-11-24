const express = require("express");
const IntegradorFonteController = require("./controllers/IntegradorFonteController");
const routes = express.Router();

routes.post("/integrador-fontes", IntegradorFonteController.create);

module.exports = routes;
