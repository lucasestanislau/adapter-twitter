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
import org.json.JSONObject;

import java.io.*;
import java.nio.charset.StandardCharsets;
import java.util.ArrayList;
import java.util.List;

public class SourceIntegrator {
    //List<BasicNameValuePair> paramsToSend = new ArrayList<>();
    //HttpPost httppost = new HttpPost("http://localhost:3333/integrador-fontes");
    static String tokenAdaptador = "b73c2d22763d1ce2143a3755c1d0ad3a";
    static CloseableHttpClient httpClient = HttpClientBuilder.create().build();
   // static HttpPost request = new HttpPost("http://localhost:3333/integrador-fontes");

    public void sendTweetEvent(TweetEvent tweetEvent) throws Exception {

        JSONObject json = new JSONObject();
        json.put("id", tweetEvent.getId());
        json.put("codigo_regra", TweetEvent.RULE_CODE);
        json.put("token", this.tokenAdaptador);
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
            //httpClient.execute(request);

        } catch (Exception ex) {
            ex.printStackTrace();
        }




       /* CloseableHttpClient httpclient = HttpClients.createDefault();
        definirParametrosRequisicao(tweetEvent);

        httpclient.execute(httppost);
        System.out.println("ok");
        HttpResponse response = httpclient.execute(httppost);
        HttpEntity entity = response.getEntity();

        if (entity != null) {
            try (InputStream instream = entity.getContent()) {
                int bufferSize = 1024;
                char[] buffer = new char[bufferSize];
                StringBuilder out = new StringBuilder(4);
                Reader in = new InputStreamReader(instream, StandardCharsets.UTF_8);
                for (int numRead; (numRead = in.read(buffer, 0, buffer.length)) > 0; ) {
                    out.append(buffer, 0, numRead);
                }
                System.out.println(out.toString());
            }
        }*/
    }

   /* private void definirParametrosRequisicao(TweetEvent tweetEvent) throws Exception{
        paramsToSend.add(new BasicNameValuePair("id", tweetEvent.getId()));
        paramsToSend.add(new BasicNameValuePair("codigo_regra", TweetEvent.RULE_CODE));
        paramsToSend.add(new BasicNameValuePair("token", this.tokenAdaptador));
        paramsToSend.add(new BasicNameValuePair("timeStamp", tweetEvent.getTimeStamp()));
        paramsToSend.add(new BasicNameValuePair("textValue", tweetEvent.getTextValue()));
        paramsToSend.add(new BasicNameValuePair("latitude", Double.toString(tweetEvent.getLatitude())));
        paramsToSend.add(new BasicNameValuePair("longitude", Double.toString(tweetEvent.getLongitude())));
        httppost.setEntity(new UrlEncodedFormEntity(paramsToSend, "UTF-8"));
    }*/
}
