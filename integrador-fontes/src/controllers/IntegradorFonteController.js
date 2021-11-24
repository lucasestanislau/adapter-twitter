const conexao = require("../database/conexao");

module.exports = {
  async create(request, response) {
    const token = request.body.token;
    if (!token) {
      return response.status(401).send("Token não informado");
    }

    let regra = null;

    try {
      regra = await conexao("regras").where("token", token).select("*").first();
    } catch (e) {
      return response.status(404).json({ message: "Conexão recusada" });
    }

    if (!regra) {
      return response.status(401).send("Token não é válido");
    }


    /*inicio da validação dos atributos a partir da regra */
    let atributosTratar = JSON.parse(regra.atributos);

    for (let i in atributosTratar) {
      if (
        !request.body[atributosTratar[i].nome] &&
        request.body[atributosTratar[i].nome] != 0
      ) {
        console.log("Erro ao registrar evento");
        return response.status(404).json({
          message:
            "atributo cadastrado na regra que não foi informado na requisição: " +
            atributosTratar[i].nome,
        });
      }

      if (atributosTratar[i].tipo === "string") {
        if (!isNaN(request.body[atributosTratar[i].nome])) {
          console.log("atributo não é uma string");
        }
      }

      if (atributosTratar[i].tipo === "number") {
        if (isNaN(request.body[atributosTratar[i].nome])) {
          console.log("atributo não é um number");
        }
      }
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

    const eventoCadastrado = await conexao("eventos").insert(evento);

    if (eventoCadastrado) {
      console.log("evento registrado: " + eventoCadastrado);

      return response.status(201).json("ok");
    } else {
      console.log("Erro ao registrar evento");

      return response.status(404).json({ error: true });
    }
  },
};
