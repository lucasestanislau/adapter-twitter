const connection = require("../database/connection");

module.exports = {
  async create(request, response) {
    const token = request.body.token;
    if (!token) {
      return response.status(401).send("Token não informado");
    }

    const regra = await connection("regras")
      .where("token", token)
      .select("*")
      .first();

    if (!regra) {
      return response.status(401).send("Token não é válido");
    }
    const atributos = request.body;

    let eventoCidade = null;
    let eventoEstado = null;
    let eventoLatitude = null;
    let eventoLongitude = null;
    let eventoDataHora = null;
    let eventoValorNumero = null;
    let eventoValorTexto = null;
    let eventoCodigo = null;

    if (!atributos[regra.campoLocalizacao2]) {
      eventoCidade = atributos[regra.campoLocalizacao1];
    } else {
      eventoCidade = atributos[regra.campoLocalizacao3]
        ? atributos[regra.campoLocalizacao3]
        : null;
      eventoLatitude = atributos[regra.campoLocalizacao1];
      eventoLongitude = atributos[regra.campoLocalizacao2];
    }

    eventoDataHora = atributos[regra.campoReferenciaDataHora];
    eventoValorNumero = atributos[regra.campoReferenciaNumero];
    eventoValorTexto = atributos[regra.campoReferenciaTexto];
    eventoCodigo = atributos[regra.campoCodigo];

    let evento = {
      regra_id: regra.id,
      latitude: eventoLatitude,
      longitude: eventoLongitude,
      cidade: eventoCidade,
      estado: eventoEstado,
      dataHora: eventoDataHora,
      codigo: eventoCodigo,
      valorNumero: eventoValorNumero,
      valorTexto: eventoValorTexto,
    };

    const eventoCadastrado = await connection("eventos").insert(evento);

    console.log("evento registrado: " + eventoCadastrado);

    return response.status(201).json("ok");
  },
};
