package com.example.badgov;



import android.app.ListActivity;
import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

public class BrowseActivity extends ListActivity {
	
	TextView statusMsg;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		String[] browsedTweets = getResources().getStringArray(R.array.tweets);
        this.setListAdapter(new ArrayAdapter<String>(this,R.layout.browse, R.id.label, browsedTweets));

        ListView lv = getListView();
	}
	

}
