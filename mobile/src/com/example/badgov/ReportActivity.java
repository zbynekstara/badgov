package com.example.badgov;

import android.app.Activity;
import android.os.Bundle;
import android.text.format.Time;
import android.view.Menu;

public class ReportActivity extends Activity{
	
	String Date;
	String time;
	String Date_Time;
	
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
		
	}
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}
}
