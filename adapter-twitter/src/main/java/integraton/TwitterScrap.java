package integraton;
import twitter4j.FilterQuery;
import twitter4j.TwitterStream;
import twitter4j.TwitterStreamFactory;
import twitter4j.conf.ConfigurationBuilder;

public class TwitterScrap implements Runnable {

    private String connectionName = "teste01";
    private String consumerKey = "IyUz5ki2t53Y70z5BcYlr1cK2";
    private String consumerSecret = "7ilU8IHGGMtheR0Hqwz8vxkBf55LTrhyLcpXlYyx6EHw6yAILs";
    private String accessToken = "1166120502466945027-roJRTE9r6j8gGOF6btFYpdQQTj4xaz";
    private String accessTokenSecret = "FZ5rAGOVskAnRKINQmoHbckZKEkJRdSuwBKxLsxZyYP2i";
    private String boundingBox = "-54.63,-26.51,-38.2,-4.47";
    private String searchWord = "";
    private FilterQuery filtre;
    private ConfigurationBuilder configurationBuilder = new ConfigurationBuilder();
    boolean bb = false, sw = false;
    TwitterStream twitterStream;

    public TwitterScrap(String connectionName, String consumerKey, String consumerSecret, String accessToken,
                           String accessTokenSecret, String searchWord, String boundingBox, String pathFiles) {
        this.connectionName = connectionName;
        this.accessTokenSecret = accessTokenSecret;
        this.accessToken = accessToken;
        this.consumerKey = consumerKey;
        this.consumerSecret = consumerSecret;
        this.searchWord = searchWord;
        this.boundingBox = boundingBox;
        this.filtre = new FilterQuery();
    }

    public TwitterScrap() {
        this.filtre = new FilterQuery();
    }

    @Override
    public void run() {
        configurationBuilder.setOAuthConsumerKey(consumerKey)
                .setOAuthConsumerSecret(consumerSecret)
                .setOAuthAccessToken(accessToken)
                .setOAuthAccessTokenSecret(accessTokenSecret);

        twitterStream = new TwitterStreamFactory(configurationBuilder.build()).getInstance();
        twitterStream.addListener(new Listener());
        configFilterWords();
        configFilterBB();
        callApi();
    }

    private void callApi() {
        if (this.bb || this.sw) {
            twitterStream.filter(this.filtre);
        } else {
            twitterStream.sample();
        }
    }

    private void configFilterWords() {
        if (this.searchWord.length() > 0) {
            this.filtre.track(this.searchWord.split(","));
            this.sw = true;
        }
    }

    private void configFilterBB() {
        if (this.boundingBox.length() > 0) {
            if (this.boundingBox.split(",").length > 3) {
                String[] cordenadas = this.boundingBox.split(",");
                try {
                    double[][] cods = {{Double.parseDouble(cordenadas[0].trim()), Double.parseDouble(cordenadas[1].trim())},
                            {Double.parseDouble(cordenadas[2].trim()), Double.parseDouble(cordenadas[3].trim())}};
                    this.filtre.locations(cods);
                } catch (Exception e) {
                    System.out.println("Filtro de Bounding Box está incorreto!!");;
                    return;
                }
                this.bb = true;
            }
        }
    }

}

