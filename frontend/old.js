import { Line } from "react-chartjs-2";
import { useEffect, useState } from "react";
import api from "./service/api";

function App() {
  const [labels, setLabels] = useState([]);
  const [dados, setDados] = useState([]);
  const [regras, setRegras] = useState([]);
  const [idsRegras, setIdsRegras] = useState([1]);
  const [dataBuscar, setDataBuscar] = useState('2021-04-01');

  const data = {
    labels: labels,
    datasets: [
      {
        label: "Twitter",
        fill: false,
        lineTension: 0.1,
        backgroundColor: "rgba(75,192,192,0.4)",
        borderColor: "rgba(75,192,192,1)",
        borderCapStyle: "butt",
        borderDash: [],
        borderDashOffset: 0.0,
        borderJoinStyle: "miter",
        pointBorderColor: "rgba(75,192,192,1)",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(75,192,192,1)",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 1,
        pointHitRadius: 10,
        data: dados,
      },
    ],
  };
  const data2 = {
    labels: [
      "01/01/2021",
      "02/01/2021",
      "03/01/2021",
      "04/01/2021",
      "05/01/2021",
      "06/01/2021",
      "07/01/2021",
    ],
    datasets: [
      {
        label: "Twitter",
        fill: false,
        lineTension: 0.1,
        backgroundColor: "rgba(75,192,192,0.4)",
        borderColor: "rgba(75,192,192,1)",
        borderCapStyle: "butt",
        borderDash: [],
        borderDashOffset: 0.0,
        borderJoinStyle: "miter",
        pointBorderColor: "rgba(75,192,192,1)",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(75,192,192,1)",
        pointHoverBorderColor: "rgba(220,220,220,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 1,
        pointHitRadius: 10,
        data: [6, 5, 8, 1, 5, 5, 40],
      },
      {
        label: "Sensores",
        fill: false,
        lineTension: 0.1,
        backgroundColor: "rgba(75,192,192,0.4)",
        borderColor: "rgba(7,19,19,1)",
        borderCapStyle: "butt",
        borderDash: [],
        borderDashOffset: 0.0,
        borderJoinStyle: "miter",
        pointBorderColor: "rgba(7,19,19,1)",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(7,19,19,1)",
        pointHoverBorderColor: "rgba(22,22,22,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 1,
        pointHitRadius: 10,
        data: [60, 50, 80, 10, 50, 50, 400],
      },
      {
        label: "Adapter3",
        fill: false,
        lineTension: 0.1,
        backgroundColor: "rgba(68,28,37,0.4)",
        borderColor: "rgba(47,87,24,1)",
        borderCapStyle: "butt",
        borderDash: [],
        borderDashOffset: 0.0,
        borderJoinStyle: "miter",
        pointBorderColor: "rgba(47,87,24,1)",
        pointBackgroundColor: "#fff",
        pointBorderWidth: 1,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(47,87,24,1)",
        pointHoverBorderColor: "rgba(120,120,120,1)",
        pointHoverBorderWidth: 2,
        pointRadius: 1,
        pointHitRadius: 10,
        data: [13, 52, 46, 74, 32, 15, 26],
      },
    ],
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

  const alterarDataBusca = (data) => {
    setDataBuscar(String(data.target.value));
  }

  const buscarEventosApi = async () => {
    const regra_id = idsRegras.toString();
    console.log(regra_id);
  };

  useEffect(() => {
    api
      .get("produzir-series", {
        params: {
          dataInicio: "2021-01-01",
          dataFim: "2021-01-01",
          palavraChave: "bolsonaro",
          intervalo: "hour",
          adaptador: "twitter-adaptador",
        },
      })
      .then((response) => {
        let indexes = [];
        let dadosApi = [];
        response.data.dados.map((value) => {
          indexes.push(value.index);
          dadosApi.push(value.value);
        });

        setLabels(indexes);
        setDados(dadosApi);
      });
  }, []);

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
          <h2>Gráfico com dados do twitter</h2>
          <Line data={data} />
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
              />
            </div>
          </div>
          <div className="mb-3 row">
            <label for="inputBoundingBox" className="col-sm-3 col-form-label">
              BoundingBox
            </label>
            <div className="col-sm-9">
              <input
                type="text"
                className="form-control"
                id="inputBoundingBox"
              />
            </div>
          </div>
          <div className="mb-3 row">
            <label for="inputDataInicio" className="col-sm-3 col-form-label">
              Data
            </label>
            <div className="col-sm-9">
              <input
                type="date"
                className="form-control"
                id="inputDataInicio"
                value={dataBuscar}
                onChange={ event => alterarDataBusca(event)}
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
              >
                <option selected>Selecione o agrupador</option>
                <option value="minuto">Minuto</option>
                <option value="hora">Hora</option>
                <option value="dia">Dia</option>
                <option value="mes">Mes</option>
                <option value="ano">Ano</option>
              </select>
            </div>
          </div>

          <div className="mb-3 row">
            <label for="inputAnalise" className="col-sm-3 col-form-label">
              Tipo de análise
            </label>
            <div className="col-sm-9">
              <select
                className="form-select form-select"
                aria-label=".form-select-sm example"
              >
                <option selected>Selecione o tipo</option>
                <option value="minuto">Frequência</option>
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
              onClick={buscarEventosApi}
            >
              Pesquisar
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default App;
