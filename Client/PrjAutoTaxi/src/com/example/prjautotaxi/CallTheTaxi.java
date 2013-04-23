package com.example.prjautotaxi;

import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;

import java.io.BufferedReader;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.text.format.Formatter;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

import java.net.InetAddress;
import java.net.NetworkInterface;
import java.net.SocketException;
import java.net.URL;
import java.net.HttpURLConnection;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.List;
import java.io.File;
import java.io.FileReader;
import java.io.InputStreamReader;
import java.io.InputStream;
import java.io.IOException;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.*;
//import android.net.Uri;

public class CallTheTaxi extends Activity {

	
	
	
    @Override
   public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        
        Button b = (Button) findViewById(R.id.button1);
        b.setOnClickListener(new OnClickListener(){
			public void onClick(View v) {
				try {
					    EditText txt = (EditText)findViewById(R.id.edittext1);
						String str=new String(txt.getText().toString());
						
						EditText txt2 = (EditText)findViewById(R.id.editText2);
						String str2=new String(txt2.getText().toString());
						
						File sdcard = Environment.getExternalStorageDirectory();
						
						File file1 = new File(sdcard,"coords1.txt");
						//File file2 = new File(sdcard,"coords2.txt");
						//File file3 = new File(sdcard,"coords3.txt");

						BufferedReader br1 = new BufferedReader(new FileReader(file1));
						//BufferedReader br2 = new BufferedReader(new FileReader(file2));
						//BufferedReader br3 = new BufferedReader(new FileReader(file3));
						
						String line_fis1=null;//,line_fis2 = null,line_fis3 = null;
						String lat1,lng1;//,lat2,lng2,lat3,lng3;
						String[] positions1;//,positions2,positions3;
						
			
						Intent i = new Intent(Intent.ACTION_VIEW);
						
						
					    

						//while(!(((line_fis1=br1.readLine())==null) && ((line_fis2=br2.readLine())==null) && ((line_fis3=br3.readLine())==null)))
						while((line_fis1=br1.readLine())!=null)
						{
							
							if(line_fis1!=null)
							{
								positions1=line_fis1.split(" ");
								lat1 = positions1[0];
								lng1=positions1[1];
								
								
								
								
								
								i.setData(Uri.parse("http://"+str+"/?id="+str2+"&lat="+lat1+"&lng="+lng1+"&ip="+getLocalIpAddress()));
								startActivity(i);
								stopService(i);
	
							}
							
							/*
							if(line_fis2!=null)
							{
								positions2=line_fis2.split(" ");
								lat2 = positions2[0];
								lng2=positions2[1];
								
								i.setData(Uri.parse("http://"+str+"/?id=2&lat="+lat2+"&lng="+lng2));
								startActivity(i);
								stopService(i);
								
							}*/
							/*
							if(line_fis3!=null)
							{
								positions3=line_fis3.split(" ");
								lat3 = positions3[0];
								lng3=positions3[1];
								
								i.setData(Uri.parse("http://"+str+"/?id=3&lat="+lat3+"&lng="+lng3));
								startActivity(i);
								stopService(i);
							}
							*/
							try 
							{
					    		Thread.sleep(3000);
					    	}
							catch (InterruptedException e) {
					    		e.printStackTrace();
					    	}
							
							
						//Intent browserIntent = new Intent(Intent.ACTION_VIEW, Uri.parse("http://www.google.com"));
						//startActivity(browserIntent);
						//URL url = new URL(str);
					   // HttpURLConnection con = (HttpURLConnection) url.openConnection();
					   // readStream(con.getInputStream());
						}
						
						br1.close();
						//br2.close();
						//br3.close();
						
					}catch (Exception e)
					{
						e.printStackTrace();
					}
			
			}
			
			});
     // Acquire a reference to the system Location Manager
    	final LocationManager locationManager = (LocationManager) this.getSystemService(Context.LOCATION_SERVICE);
    	
        Button b2 = (Button) findViewById(R.id.button2);
        b2.setOnClickListener(new OnClickListener(){
			public void onClick(View v) {
				try 
				{
					EditText txt = (EditText)findViewById(R.id.edittext1);
					final String str=new String(txt.getText().toString());
					
					EditText txt2 = (EditText)findViewById(R.id.editText2);
					final String str2=new String(txt2.getText().toString());
					
					final Intent i = new Intent(Intent.ACTION_VIEW);

					// Define a listener that responds to location updates
					LocationListener locationListener = new LocationListener() {
					    public void onLocationChanged(Location location) {
					      // Called when a new location is found by the network location provider.
					    	i.setData(Uri.parse("http://"+str+"/?id="+str2+"&lat="+Double.toString(location.getLatitude())+"&lng="+Double.toString(location.getLongitude())+"&ip="+getLocalIpAddress()));
					    	startActivity(i);
							stopService(i);
					    }

					    public void onStatusChanged(String provider, int status, Bundle extras) {}

					    public void onProviderEnabled(String provider) {}

					    public void onProviderDisabled(String provider) {}
					  };

					// Register the listener with the Location Manager to receive location updates
					locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 0, 0, locationListener);
					
				
				}
				catch (Exception e2)
				{
					e2.printStackTrace();
				}
				
			}
        });
        
        
        
			
    }
    
    public String getLocalIpAddress() {
        try {
            for (Enumeration<NetworkInterface> en = NetworkInterface.getNetworkInterfaces(); en.hasMoreElements();) {
                NetworkInterface intf = en.nextElement();
                for (Enumeration<InetAddress> enumIpAddr = intf.getInetAddresses(); enumIpAddr.hasMoreElements();) {
                    InetAddress inetAddress = enumIpAddr.nextElement();
                    if (!inetAddress.isLoopbackAddress()) {
                        String ip = Formatter.formatIpAddress(inetAddress.hashCode());
                        //Log.i(TAG, "***** IP="+ ip);
                        return ip;
                    }
                }
            }
        } catch (SocketException ex) {
            //Log.e(TAG, ex.toString());
        }
        return null;
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_main, menu);
        return true;
    }
}
