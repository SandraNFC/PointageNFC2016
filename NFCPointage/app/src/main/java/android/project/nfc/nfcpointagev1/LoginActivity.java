package android.project.nfc.nfcpointagev1;

import android.app.Activity;

import android.app.AlertDialog;
import android.app.DownloadManager;
import android.app.ProgressDialog;
import android.os.Bundle;
import android.os.StrictMode;
import android.view.Menu;
import android.view.MenuItem;
import android.content.Intent;
import android.os.AsyncTask;

import android.util.Log;

import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;


import org.apache.http.NameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import service.ServiceHandler;
import sessions.SessionManager;
import urls.Url;


public class LoginActivity extends Activity {

    EditText login;
    EditText password;
    TextView errorMessage;
    Button connexion;

    HashMap<String,String> etudiantConnecte;

    private ProgressDialog pDialog;


    private SessionManager session;

    ServiceHandler sh;

    // JSON Node names
    private static final String TAG_IDUSER = "IDETUDIANT";
    private static final String TAG_IDPROMOTION = "IDPROMOTION";
    private static final String TAG_NOM = "NOM";
    private static final String TAG_PRENOM = "PRENOM";
    //private static final String TAG_DATENAISS = "DATENAISS";
    private static final String TAG_LOGIN = "PSEUDO";
    private static final String TAG_PASS = "MOTDEPASSE";

    //JSONParser jParser = new JSONParser();

    String idEtudiant="";
    String idPromotion = "";


    ArrayList<HashMap<String, String>> etudiantsList;

    AlertDialog alertDialog;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        login = (EditText) findViewById(R.id.editEmail);
        password = (EditText) findViewById(R.id.editPassword);

        errorMessage = (TextView) findViewById(R.id.errorMessage);

        connexion = (Button) findViewById(R.id.btnRegister);

        // alert dialog
        alertDialog = new AlertDialog.Builder(LoginActivity.this).create();

        session = new SessionManager(LoginActivity.this);

        // check session
        if(session.isLoggedIn())
        {
            Intent intent = new Intent(LoginActivity.this, MainActivity.class);
            startActivity(intent);
        }


        connexion.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                new LoginUser().execute();
            }
        });
    }


    class LoginUser extends AsyncTask<String, String, String> {

        String loginEtudiant = login.getText().toString();
        String passEtudiant = password.getText().toString();


        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pDialog = new ProgressDialog(LoginActivity.this);
            pDialog.setMessage("Connecting. Please wait...");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(true);
            //pDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {


            sh = new ServiceHandler();


            if(loginEtudiant.trim().length() > 0 && passEtudiant.trim().length() >0)
            {

                try {

                    String json = sh.makeServiceCall(Url.URL_ETUDIANT,ServiceHandler.GET);
                    JSONArray jArray = new JSONArray(json);

                    for(int i=0;i<jArray.length();i++)
                    {
                        JSONObject jObject = jArray.getJSONObject(i);
                        if(loginEtudiant.equals(jObject.getString(TAG_LOGIN)) && passEtudiant.equals(jObject.getString(TAG_PASS)))
                        {
                            session.createLoginSession(jObject.getString(TAG_IDPROMOTION),jObject.getString(TAG_IDUSER));
                            //session.createLoginSession("idPromotion",jObject.getString(TAG_IDPROMOTION));
                            Log.e("PROMOTION ID: ", jObject.getString(TAG_IDPROMOTION));

                            Intent intent = new Intent(LoginActivity.this, MainActivity.class);
                            startActivity(intent);
                           // finish();
                        }
                        else{
                            /* alertDialog.setTitle("Erreur");
                            alertDialog.setMessage("Login failed..\", \"Username/Password is incorrect");
                            alertDialog.show();*/
                        }
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }

            }
            else{
                alertDialog.setTitle("Erreur");
                alertDialog.setMessage("Login failed..\", \"Please enter username and password");
                alertDialog.show();
            }

            return null;
        }

        protected void onPostExecute(String file_url) {
            // dismiss the dialog once done
            //if (pDialog.isShowing())
                pDialog.dismiss();

        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_login, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}
