package com.example.badgov;


import java.io.File;
import java.io.IOException;

import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.app.Activity;
import android.content.Intent;

public class MainActivity extends Activity implements View.OnClickListener {
	
	int TAKE_PHOTO_CODE = 0;
	public static int count=0;
	Button skip;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		final String dir = Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_PICTURES) + "/picFolder/"; 
		File newdir = new File(dir); 
        newdir.mkdirs();
        
        skip = (Button) findViewById(R.id.skipImage);
        skip.setOnClickListener(this);
        
        Button capture = (Button) findViewById(R.id.btnCapture);
        capture.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {

                // here,counter will be incremented each time,and the picture taken by camera will be stored as 1.jpg,2.jpg and likewise.
                count++;
                String file = dir+count+".jpg";
                File newfile = new File(file);
                try {
                    newfile.createNewFile();
                } catch (IOException e) {}       

                Uri outputFileUri = Uri.fromFile(newfile);

                Intent cameraIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE); 
                cameraIntent.putExtra(MediaStore.EXTRA_OUTPUT, outputFileUri);

                startActivityForResult(cameraIntent, TAKE_PHOTO_CODE);
            }
        });
        
	}
	
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	    super.onActivityResult(requestCode, resultCode, data);

	    
        Intent x = new Intent(MainActivity.this,ReportActivity.class);
        startActivity(x);
        
        
	    if (requestCode == TAKE_PHOTO_CODE && resultCode == RESULT_OK) {
	        Log.d("CameraDemo", "Pic saved");
	    }
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}

	@Override
	public void onClick(View v) {
		// TODO Auto-generated method stub
		
		switch(v.getId()){
		case R.id.skipImage:{
			Intent x = new Intent(MainActivity.this,ReportActivity.class);
            startActivity(x);
		}
		}
		
	}

}
