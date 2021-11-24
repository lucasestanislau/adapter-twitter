package integraton;
import models.SourceIntegrator;
import models.TweetEvent;
import twitter4j.StallWarning;
import twitter4j.Status;
import twitter4j.StatusDeletionNotice;
import twitter4j.StatusListener;

import java.sql.Connection;
import java.text.SimpleDateFormat;
import java.util.Date;

public class Listener implements StatusListener {

    private SourceIntegrator integrator = new SourceIntegrator();

    public Listener() {
    }

    @Override
    public void onStatus(Status status) {

        if (status.getPlace() != null && status.getGeoLocation() != null) {

            SimpleDateFormat sdfDate = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
            Date now = new Date(status.getCreatedAt().getTime());
            String strDate = sdfDate.format(now);

            TweetEvent tweetEvent = new TweetEvent();
            tweetEvent.setId(Long.toString(status.getId()));
            tweetEvent.setTimeStamp(strDate);
            tweetEvent.setCity(status.getPlace().getName());
            tweetEvent.setLatitude(status.getGeoLocation().getLatitude());
            tweetEvent.setLongitude(status.getGeoLocation().getLongitude());
            tweetEvent.setTextValue(status.getText());

            System.out.println("Salvo Tweet: "+ tweetEvent.getId());
            tweetEvent.sendToSourceIntegrator(tweetEvent, integrator);
        }
    }

    @Override
    public void onDeletionNotice(StatusDeletionNotice sdn) {
    }

    @Override
    public void onTrackLimitationNotice(int i) {
    }

    @Override
    public void onScrubGeo(long l, long l1) {
    }

    @Override
    public void onStallWarning(StallWarning sw) {
    }

    @Override
    public void onException(Exception excptn) {
        excptn.printStackTrace();
    }

}
