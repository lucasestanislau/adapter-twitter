import { Line } from "react-chartjs-2";
import { useEffect, useState } from "react";
import api from "./service/api";
import apiMiddleware from "./service/apiMiddleware";

function App() {
  const [labels, setLabels] = useState([]);
  const [dadosGrafico, setDadosGrafico] = useState([]);
  const [dadosApi, setDadosApi] = useState([]);
  const [regras, setRegras] = useState([]);
  const [idsRegras, setIdsRegras] = useState([]);
  const [dataBuscarInicio, setDataBuscarInicio] = useState("2021-10-20");
  const [dataBuscarFim, setDataBuscarFim] = useState("2021-10-20");
  const [agrupador, setAgrupador] = useState("");
  const [palavraChave, setPalavraChava] = useState("chuva");
  const [estado, setEstado] = useState("São paulo");
  const [cidade, setCidade] = useState("São paulo");

  const handleDadosGrafico = () => {
    if (dadosApi.length < 1) {
      return;
    }

    let arrayLabels = dadosApi[0].dados.map((d) => d.index);
    setDadosGrafico({
      labels: arrayLabels,
      datasets: dadosApi.map((dado) => {
        const cor1 = 'rgb(' + (Math.random() * (255 - 0) + 0) + ', ' + (Math.random() * (255 - 0) + 0) + ', ' + (Math.random() * (255 - 0) + 0) + ')';
        const cor2 = 'rgb(' + (Math.random() * (255 - 0) + 0) + ', ' + (Math.random() * (255 - 0) + 0) + ', ' + (Math.random() * (255 - 0) + 0) + ')';
       
        return {
          label: dado.codigoRegra,
          fill: false,
          lineTension: 0.1,
          backgroundColor: cor1,
          borderColor: cor1,
          borderCapStyle: "butt",
          borderDash: [],
          borderDashOffset: 0.0,
          borderJoinStyle: "miter",
          pointBorderColor: cor1,
          pointBackgroundColor: "#fff",
          pointBorderWidth: 1,
          pointHoverRadius: 5,
          pointHoverBackgroundColor: cor1,
          pointHoverBorderColor: cor2,
          pointHoverBorderWidth: 2,
          pointRadius: 1,
          pointHitRadius: 10,
          data: dado.dados.map((d) => d.valor),
        };
      }),
    });
  };

  const handleIdRegraCheckbox = (id, checked) => {
    if (checked) {
      if (idsRegras) {
        setIdsRegras([...idsRegras, id]);
      } else {
        setIdsRegras([id]);
      }
    } else {
      setIdsRegras(idsRegras.filter((regra) => regra != id));
    }
  };

  /**Busca eventos API */
  const buscarEventosApi = async () => {
    const regras_ids = idsRegras.toString();
console.log('agrupador', agrupador);
    api
      .get("series", {
        params: {
          data_inicio: dataBuscarInicio,
          data_fim: dataBuscarFim,
          regras_ids: regras_ids,
          agrupador: agrupador,
          palavra_chave: palavraChave,
          cidade: cidade,
          estado: estado,
        },
      })
      .then((response) => {
        setDadosApi(response.data);
        handleDadosGrafico();
      });
  };

  useEffect(() => {
    const getRegras = async () => {
      const regras = await api.get("/regras");
      setRegras(regras.data);
    };

    getRegras();
  }, []);



  return (
    <div className="container" style={{ marginTop: 20 }}>
      <div className="row">
        <div className="col">
          <h2>Gráfico com dados coletados pelos adaptadores</h2>
          <Line data={dadosGrafico} />
        </div>
        <div className="col">
          <div className="mb-3 row">
            <label for="inputPalavrachave" className="col-sm-3 col-form-label">
              Valor chave
            </label>
            <div className="col-sm-9">
              <input
                type="text"
                className="form-control"
                id="inputPalavrachave"
                value={palavraChave}
                onChange={(e) => setPalavraChava(e.target.value)}
              />
            </div>
          </div>
          <div className="mb-3 row">
            <label for="inputEstado" className="col-sm-3 col-form-label">
              Estado
            </label>
            <div className="col-sm-9">
              <input
                type="text"
                className="form-control"
                id="inputEstado"
                value={estado}
                onChange={(e) => setEstado(e.target.value)}
              />
            </div>
          </div>
          <div className="mb-3 row">
            <label for="inputCidade" className="col-sm-3 col-form-label">
              Cidade
            </label>
            <div className="col-sm-9">
              <input
                type="text"
                className="form-control"
                id="inputCidade"
                value={cidade}
                onChange={(e) => setCidade(e.target.value)}
              />
            </div>
          </div>

          <div className="mb-3 row">
            <label for="dataBuscarInicio" className="col-sm-3 col-form-label">
              Data Início
            </label>
            <div className="col-sm-9">
              <input
                type="text"
                className="form-control"
                id="dataBuscarInicio"
                value={dataBuscarInicio}
                onChange={(e) => setDataBuscarInicio(e.target.value)}
              />
            </div>
          </div>

          <div className="mb-3 row">
            <label for="inputDataFim" className="col-sm-3 col-form-label">
              Data Fim
            </label>
            <div className="col-sm-9">
              <input
                type="text"
                className="form-control"
                id="inputDataFim"
                value={dataBuscarFim}
                onChange={(e) => setDataBuscarFim(e.target.value)}
              />
            </div>
          </div>
          <div className="mb-3 row">
            <label for="inputAgrupador" className="col-sm-3 col-form-label">
              Agrupador
            </label>
            <div className="col-sm-9">
              <select
                className="form-select form-select"
                aria-label=".form-select-sm example"
                value={agrupador}
                onChange={(e) => setAgrupador(e.target.value)}
              >
                <option selected>Selecione o agrupador</option>
                <option value="hora">Hora</option>
                <option value="dia">Dia</option>
                <option value="mes">Mes</option>
                <option value="ano">Ano</option>
              </select>
            </div>
          </div>

          <div className="row">
            {regras.map((regra) => {
              return (
                <div className="form-check" key={regra.id}>
                  <input
                    className="form-check-input"
                    type="checkbox"
                    onChange={(e) => {
                      handleIdRegraCheckbox(e.target.value, e.target.checked);
                    }}
                    value={regra.id}
                    id={regra.id}
                  />
                  <label className="form-check-label" for={regra.id}>
                    {regra.codigoRegra}
                  </label>
                </div>
              );
            })}
          </div>
          <div className="row">
            <button
              type="button"
              className="btn btn-secondary col-md-3 offset-md-8"
              style={{ alignItems: "end" }}
              onClick={() => buscarEventosApi()}
            >
              Gerar
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default App;
