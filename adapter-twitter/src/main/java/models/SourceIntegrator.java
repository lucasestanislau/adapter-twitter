package models;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClientBuilder;
import org.apache.http.impl.client.HttpClients;
import org.apache.http.message.BasicNameValuePair;
import twitter4j.JSONObject;


import java.io.*;
import java.nio.charset.StandardCharsets;
import java.util.ArrayList;
import java.util.List;

public class SourceIntegrator {
    static String adapterToken = "b73c2d22763d1ce2143a3755c1d0ad3a";
    static CloseableHttpClient httpClient = HttpClientBuilder.create().build();

    public void sendTweetEvent(TweetEvent tweetEvent) throws Exception {

        if(adapterToken == ""){
            registrarRegraAdaptador();
        }

        JSONObject json = new JSONObject();
        json.put("id", tweetEvent.getId());
        json.put("codigo_regra", TweetEvent.RULE_CODE);
        json.put("token", this.getAdapterToken());
        json.put("timeStamp", tweetEvent.getTimeStamp());
        json.put("textValue", tweetEvent.getTextValue());
        json.put("latitude", Double.toString(tweetEvent.getLatitude()));
        json.put("longitude", Double.toString(tweetEvent.getLongitude()));

        try {
            HttpPost request = new HttpPost("http://localhost:3333/integrador-fontes");
            StringEntity params = new StringEntity(json.toString());
            request.addHeader("content-type", "application/json");
            request.setEntity(params);

            CloseableHttpClient httpclient = HttpClients.createDefault();
            httpclient.execute(request);
            System.out.println("ok");

        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }

    public String getAdapterToken() {
        return adapterToken;
    }

    public void setAdapterToken(String adapterToken){
        this.adapterToken = adapterToken;
    }

    public void registrarRegraAdaptador(){
        JSONObject json = new JSONObject();
        json.put("codigoRegra", "cemaden-pluviometrica");
        json.put("nomeFonte", "cemaden");
        json.put("nomeAdaptador", "cemaden-p");
        json.put("atributos", "[\n" +
                "\n" +
                "\t\t{\"nome\": \"codestacao\", \"tipo\" : \"string\"},\n" +
                "\t\t{\"nome\": \"tipo\", \"tipo\" : \"dateTime\"},\n" +
                "\t\t{\"nome\": \"latitude\", \"tipo\" : \"number\"},\n" +
                "\t\t{\"nome\": \"longitude\", \"tipo\" : \"number\"},\n" +
                "\t\t{\"nome\": \"chuva\", \"tipo\" : \"number\"},\n" +
                "\t\t{\"nome\": \"dataHora\", \"tipo\" : \"dateTime\"},\n" +
                "\t\t{\"nome\": \"nome\", \"tipo\" : \"string\"},\n" +
                "\t\t{\"nome\": \"uf\", \"tipo\" : \"string\"},\n" +
                "\t\t{\"nome\": \"cidade\", \"tipo\" : \"string\"}\n" +
                "\t]");
        json.put("campoReferenciaTexto", null);
        json.put("campoReferenciaNumero", "chuva");
        json.put("campoReferenciaDataHora", "dataHora");
        json.put("campoLocalizacao1", "latitude");
        json.put("campoLocalizacao2", "longitude");
        json.put("campoLocalizacao3", "cidade");
        json.put("campoCodigo", "codestacao");
        json.put("descricao", "Regra referente ao adaptador que coleta dados do cemaden");

        try {
            HttpPost request = new HttpPost("http://localhost:8082/registrar-adaptador");
            StringEntity params = new StringEntity(json.toString());
            request.addHeader("content-type", "application/json");
            request.setEntity(params);

            CloseableHttpClient httpclient = HttpClients.createDefault();
            httpclient.execute(request);
            System.out.println("Regra cadastrada");

        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }


}
