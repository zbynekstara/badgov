package com.example.badgov;

import java.io.IOException;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
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
import android.widget.Toast;

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
	
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.report);
		Time today = new Time(Time.getCurrentTimezone());
		today.setToNow();
		int mon = today.month;
		mon +=1;
		Date = Integer.toString(today.monthDay) + "-" + Integer.toString( mon) + "-" + Integer.toString(today.year);
		time = today.format("%H") + " : " + today.format("%M") + " : " + today.format("%S");
		Date_Time = time + " | " + Date;
		loc_mgr = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
		
		Location location = loc_mgr.getLastKnownLocation(LocationManager.GPS_PROVIDER);
		
		if(location != null && location.getTime() > Calendar.getInstance().getTimeInMillis() - 2 * 60 * 1000) {
            // Do something with the recent location fix
            //  otherwise wait for the update below
        }
        else {
            loc_mgr.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, this);
        }
		
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

			
			//progressDialog= ProgressDialog.show(ReportActivity.this, "Loading...","Checking", true);
		//	progressDialog.show();
	    }
		
	    @Override
	    protected Boolean doInBackground(Void... params) {
	    	
	    	
	        return null;
	    }
	    
	    @Override
	    protected void onPostExecute(Boolean result) {

			super.onPostExecute(result);
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
