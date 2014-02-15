package com.example.badgov;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.HttpMultipartMode;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpParams;
import org.apache.http.util.EntityUtils;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.res.Resources;
import android.graphics.drawable.Drawable;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.Settings;
import android.text.format.Time;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.Toast;
import org.apache.http.HttpEntity;
import com.loopj.android.http.*;


public class ReportActivity extends Activity implements LocationListener{
	
	String Date;
	String time;
	String Date_Time;
	
	double lat;
	double lon;
	
	LocationManager loc_mgr;
	ProgressDialog progressDialog;
	
	String provider;
	
	getLocation get_location;
	
	String address;
	
	EditText review, where;
	TextView location_text, date;
	ImageView tumbnail;
	Button submit;
	
	RadioButton Bad;
	RadioButton Corruption;
	
	String comment;
	String where_place;
	String current_location;
	int selection;
	String file_path;
	
	getLocation gets;
	private DefaultHttpClient mHttpClient;
	
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.report);
		
	    review = (EditText) findViewById(R.id.editText1);
		where = (EditText) findViewById(R.id.whereEditTxt);
		location_text = (TextView) findViewById(R.id.locationTxtView);
		date = (TextView) findViewById(R.id.dateTextView);
		Bad = (RadioButton) findViewById(R.id.badServiceRadio);
		Corruption = (RadioButton) findViewById(R.id.corruptionServiceRadio);
		tumbnail = (ImageView) findViewById(R.id.imageView1);
		
		
		file_path = MainActivity.file;
		
		/*Resources res = getResources();
		String mDrawableName = file_path;
		int resID = res.getIdentifier(mDrawableName , "drawable", getPackageName());
		Drawable drawable = res.getDrawable(resID );
		tumbnail.setImageDrawable(drawable);*/
		
		
		Time today = new Time(Time.getCurrentTimezone());
		today.setToNow();
		int mon = today.month;
		mon +=1;
		Date = Integer.toString(today.monthDay) + "-" + Integer.toString( mon) + "-" + Integer.toString(today.year);
		time = today.format("%H") + " : " + today.format("%M") + " : " + today.format("%S");
		Date_Time = time + " | " + Date;
		date.setText(Date_Time);
		
		submit = (Button) findViewById(R.id.submitBtn);

		loc_mgr = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
		
		Location location = loc_mgr.getLastKnownLocation(LocationManager.GPS_PROVIDER);
		
		if(location != null && location.getTime() > Calendar.getInstance().getTimeInMillis() - 2 * 60 * 1000) {
            // Do something with the recent location fix
            //  otherwise wait for the update below
        }
        else {
            loc_mgr.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, this);
        }
		
		
		submit.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				
				comment = review.getText().toString();
				where_place = where.getText().toString();
				
				if(Bad.isChecked()){
					selection = 1;
				}
				else if(Corruption.isChecked()){
					selection = 2;
				}

				gets = new getLocation();
				gets.execute((Void) null);
				
				////////////////////////EDIT THIS !
				//Intent x = new Intent(ReportActivity.this,BrowseActivity.class);
		        //startActivity(x);
			}
		});
		
	}
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}
	
	

	
class getLocation extends AsyncTask<Void, Void, Boolean> {
		
		
		@Override
	    protected void onPreExecute()
	    {
			progressDialog= ProgressDialog.show(ReportActivity.this, "Loading...","Checking Lock", true);
			progressDialog.show();
	    }
		
	    @Override
	    protected Boolean doInBackground(Void... params) {
	    	
	    	HttpParams paramsx = new BasicHttpParams();
	    	mHttpClient = new DefaultHttpClient(paramsx);
	    	
			try {
	    	HttpClient client = new DefaultHttpClient();
			HttpPost post = new HttpPost("http://www.badgov.com.nu/public/submit");
			
			List<NameValuePair> pairs = new ArrayList<NameValuePair>();
			pairs.add(new BasicNameValuePair("report_Desc", comment));
			pairs.add(new BasicNameValuePair("report_type", String.valueOf(selection)));
			pairs.add(new BasicNameValuePair("Date_Time", Date_Time));
			
			
			pairs.add(new BasicNameValuePair("loc_longitude", String.valueOf(lon)));
			pairs.add(new BasicNameValuePair("loc_latitude", String.valueOf(lat)));
			pairs.add(new BasicNameValuePair("loc_location", address));
			
			
			/*
			 *  multipartEntity.addPart("report_Desc", new StringBody(comment));
        		multipartEntity.addPart("report_type", new StringBody(String.valueOf(selection)));
        		multipartEntity.addPart("Date_Time", new StringBody(Date_Time));
        		
        		multipartEntity.addPart("loc_longitude", new StringBody(String.valueOf(lon)));
        		multipartEntity.addPart("loc_latitude", new StringBody(String.valueOf(lat)));
        		multipartEntity.addPart("loc_location", new StringBody(address));
        		
			 * 
			 * 
			 * 
			 * 
			 */
			
			post.setEntity(new UrlEncodedFormEntity(pairs));
			HttpResponse response = client.execute(post);
			
			
			MultipartEntity multipartEntity = new MultipartEntity(HttpMultipartMode.BROWSER_COMPATIBLE);
			File image = new File(file_path);
			multipartEntity.addPart("file_image", new FileBody(image));
			post.setEntity(multipartEntity);
			mHttpClient.execute(post, new PhotoUploadResponseHandler());
			
			
			
			
				} catch (UnsupportedEncodingException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
					Log.i("UnsupportedEncoding", e.toString());
				} catch (ClientProtocolException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
					Log.i("ClientProtocol", e.toString());
				} catch (IOException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
					Log.i("IOException", e.toString());
				}
				
	        return null;
	    }
	    
	    @Override
	    protected void onPostExecute(Boolean result) {

			super.onPostExecute(result);
			progressDialog.dismiss();
			

	    }
	}



private class PhotoUploadResponseHandler implements ResponseHandler<Object> {

    @Override
    public Object handleResponse(HttpResponse response)
            throws ClientProtocolException, IOException {

        HttpEntity r_entity = response.getEntity();
        String responseString = EntityUtils.toString(r_entity);
        Log.d("UPLOAD", responseString);

        return null;
    }

}

@Override
public void onLocationChanged(Location location) {
	// TODO Auto-generated method stub
	if (location != null) {
        Log.v("Location Changed", location.getLatitude() + " and " + location.getLongitude());
        //we got the coordinates
        lon = location.getLongitude();
        lat = location.getLatitude();
        Geocoder geocode = new Geocoder(this, Locale.getDefault());
        List<Address> addresses;
        
        try{
        	addresses = geocode.getFromLocation(location.getLatitude(), location.getLongitude(), 1);
			address = addresses.get(0).getAddressLine(0) + " - " + addresses.get(0).getAddressLine(1) + " - " +addresses.get(0).getAddressLine(2);
			location_text.setText(address);
			
			
			//not working
			Resources res = getResources();
			String mDrawableName = file_path;
			int resID = res.getIdentifier(mDrawableName , "drawable", getPackageName());
			Drawable drawable = res.getDrawable(resID);
			tumbnail.setImageDrawable(drawable);
        }
        catch(Exception e){
        	Log.i("Geocode_Exc", e.toString());
        }
        loc_mgr.removeUpdates(this);
    }
}

@Override
public void onProviderDisabled(String arg0) {
	// TODO Auto-generated method stub
	
}

@Override
public void onProviderEnabled(String arg0) {
	// TODO Auto-generated method stub
}

@Override
public void onStatusChanged(String arg0, int arg1, Bundle arg2) {
	// TODO Auto-generated method stub
	
}

}
