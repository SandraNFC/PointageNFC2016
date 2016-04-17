package android.project.nfc.nfcpointagev1;

import android.app.AlertDialog;
import android.app.Fragment;
import android.app.FragmentManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.res.Configuration;
import android.content.res.TypedArray;
import android.nfc.NdefMessage;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Parcelable;
import android.support.v4.app.ActionBarDrawerToggle;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.List;

import adapter.NavDrawerListAdapter;
//import fragments.AbsencesFragment;
import fragments.HomeFragment;
//import fragments.PresencesFragment;
import fragments.ListePointageFragment;
import navigations.NavDrawerItem;
import service.ServiceHandler;
import sessions.SessionManager;
import urls.Url;

public class MainActivity extends ActionBarActivity {

    private DrawerLayout mDrawerLayout;
    private ListView mDrawerList;
    private ActionBarDrawerToggle mDrawerToggle;

    // TAG
    private static final String TAG_IDSC = "IDSC";
    private static final String TAG_IDEC = "idec";
    private static final String TAG_IDCOURS = "IDCOURS";
    private static final String TAG_IDPROMOTION = "IDPROMOTION";
    private static final String TAG_PROMOTION = "PROMOTION";
    private static final String TAG_IDSALLE = "IDSALLE";
    private static final String TAG_IDUSER = "iduser";
    private static final String TAG_HEUREENTREE = "HEUREENTREE";
    private static final String TAG_HEURESORTIE = "HEURESORTIE";
    private static final String TAG_NUMSALLE = "NUMSALLE";
    private static final String TAG_COURS = "COURS";
    private static final String TAG_NOM = "nom";
    private static final String TAG_LOGIN = "login";

    SessionManager session;

    // nav drawer title
    private CharSequence mDrawerTitle;

    // used to store app title
    private CharSequence mTitle;

    // slide menu items
    private String[] navMenuTitles;
    private TypedArray navMenuIcons;

    private ArrayList<NavDrawerItem> navDrawerItems;
    private NavDrawerListAdapter adapter;

    String idEtudiant = "";
    String idPromotion = "";

    AlertDialog alertDialog;
    boolean isPointageOK, isSalleOK = true;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        session = new SessionManager(getApplicationContext());
        if(!session.isLoggedIn())
        {
            Intent in = new Intent(MainActivity.this, LoginActivity.class);
            startActivity(in);
        }

         /* SESSION */

        session.checkLogin();
        HashMap<String,String> etudiantSession = session.getUserDetails();

        idEtudiant = etudiantSession.get(SessionManager.KEY_IDUSER);
        idPromotion = etudiantSession.get(SessionManager.KEY_NAME);

       //isPointageOK = new Boolean("false");

        new PointageCheck().execute();



        // load slide menu items
        navMenuTitles = getResources().getStringArray(R.array.nav_drawer_items);

        // nav drawer icons from resources
        navMenuIcons = getResources().obtainTypedArray(R.array.nav_drawer_icons);

        mDrawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
        mDrawerList = (ListView) findViewById(R.id.list_slidermenu);



        navDrawerItems = new ArrayList<NavDrawerItem>();

        // adding nav drawer items to array
        // Home
        navDrawerItems.add(new NavDrawerItem(navMenuTitles[0], navMenuIcons.getResourceId(0, -1)));
        // Presences
        navDrawerItems.add(new NavDrawerItem(navMenuTitles[1], navMenuIcons.getResourceId(1, -1)));
        // Absences
        // navDrawerItems.add(new NavDrawerItem(navMenuTitles[2], navMenuIcons.getResourceId(2, -1)));



        // Recycle the typed array
        navMenuIcons.recycle();

        mDrawerList.setOnItemClickListener(new SlideMenuClickListener());

        // setting the nav drawer list adapter
        adapter = new NavDrawerListAdapter(getApplicationContext(),
                navDrawerItems);
        mDrawerList.setAdapter(adapter);

        // enabling action bar app icon and behaving it as toggle button
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);
        getSupportActionBar().setHomeAsUpIndicator(R.drawable.ic_drawer);

        mDrawerToggle = new ActionBarDrawerToggle(this, mDrawerLayout,
                R.drawable.ic_drawer, //nav menu toggle icon
                R.string.app_name, // nav drawer open - description for accessibility
                R.string.app_name // nav drawer close - description for accessibility
        ) {
            public void onDrawerClosed(View view) {
                getSupportActionBar().setTitle(mTitle);
                // calling onPrepareOptionsMenu() to show action bar icons
                invalidateOptionsMenu();
            }

            public void onDrawerOpened(View drawerView) {
                getSupportActionBar().setTitle(mDrawerTitle);
                // calling onPrepareOptionsMenu() to hide action bar icons
                invalidateOptionsMenu();
            }
        };
        mDrawerLayout.setDrawerListener(mDrawerToggle);

        if (savedInstanceState == null) {
            // on first time display view for first nav item
            displayView(0);
        }
    }

    class PointageCheck extends AsyncTask<String, String, String>{

        public static final String ERROR_DETECTED = "No NFC tag detected!";

        NfcAdapter nfcAdapter;
        PendingIntent pendingIntent;
        IntentFilter writeTagFilters[];
        boolean writeMode;
        Tag myTag;
        Context context;

        String idsalle="";


        Calendar cal = Calendar.getInstance();
        Date currentDate = cal.getTime();

        DateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        DateFormat sdfWithoutHours = new SimpleDateFormat("yyyy-MM-dd");

        @Override
        protected void onPreExecute()
        {
            super.onPreExecute();
            alertDialog = new AlertDialog.Builder(MainActivity.this).create();
        }



        @Override
        protected String doInBackground(String... s) {

             /* Pointage */
            // Lecture TAG NFC

            nfcAdapter = NfcAdapter.getDefaultAdapter(getApplicationContext());
            if (nfcAdapter == null) {
                // Stop here, we definitely need NFC
                Toast.makeText(getApplicationContext(), "This device doesn't support NFC.", Toast.LENGTH_LONG).show();
                //finish();
            }
            idsalle = readFromIntent(getIntent());

            pendingIntent = PendingIntent.getActivity(getApplicationContext(), 0, new Intent(getApplicationContext(), getClass()).addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP), 0);
            IntentFilter tagDetected = new IntentFilter(NfcAdapter.ACTION_TAG_DISCOVERED);
            tagDetected.addCategory(Intent.CATEGORY_DEFAULT);
            writeTagFilters = new IntentFilter[] { tagDetected };


            ServiceHandler sh = new ServiceHandler();



            try{
                String json = sh.makeServiceCall(Url.URL_EMPLPOI_DU_TEMP,ServiceHandler.GET);

                JSONArray jArray = new JSONArray(json);
                for(int i=0;i<jArray.length();i++)
                {
                    JSONObject jObject = jArray.getJSONObject(i);

                    /* Date debut et date fin d'un cours dans une salle */

                    Date dateEntree = sdf.parse(jObject.getString(TAG_HEUREENTREE));
                    Date dateSortie = sdf.parse(jObject.getString(TAG_HEURESORTIE));

                    /* current date and date entree without hours */

                    String currentDateWithoutHours = sdfWithoutHours.format(currentDate);
                    String dateEntreeWithoutHours = sdfWithoutHours.format(dateEntree);

                    Log.e("Date entree test: ",String.valueOf(currentDate.after(dateEntree)));
                    Log.e("Date sortie test: ",String.valueOf(currentDate.before(dateSortie)));
                    Log.e("Id etudiant : ",idEtudiant);
                    //Log.e("Id etudiant ok or NOT: ",String.valueOf(jObject.getString("iduser").equals(idEtudiant)));


                    if(!idsalle.equals(""))
                    {
                        if(currentDateWithoutHours.equals(dateEntreeWithoutHours))
                        {
                            if(jObject.getString(TAG_IDSALLE).equals(idsalle) &&  currentDate.after(dateEntree) && currentDate.before(dateSortie) && jObject.getString(TAG_IDPROMOTION).equals(idPromotion))
                            {
                                String idpointage = "0";
                                String idsallecours = jObject.getString(TAG_IDSC);
                                String idetudiant = idEtudiant;
                                String heureEntree = sdf.format(currentDate);

                                //ServiceHandler sh = new ServiceHandler();

                                List<NameValuePair> params = new ArrayList<NameValuePair>();

                                params.add(new BasicNameValuePair("IDPOINTAGE", idpointage));
                                params.add(new BasicNameValuePair("IDSC", idsallecours));
                                params.add(new BasicNameValuePair("IDETUDIANT", idetudiant));
                                params.add(new BasicNameValuePair("HEUREENTREEETUDIANT", heureEntree));

                                String jsonPointage = sh.makeServiceCall(Url.URL_POINTAGE, ServiceHandler.POST, params);

                                isPointageOK = true;
                                isSalleOK = true;
                            }
                            else if(!jObject.getString(TAG_IDSALLE).equals(idsalle)){
                                isSalleOK = false;
                            }
                        }
                    }
                }
            }
            catch(Exception ex)
            {

            }

            return null;
        }

        @Override
        protected void onPostExecute(String s)
        {
            super.onPostExecute(s);
            alertDialog.setTitle("Pointage");

            if(isPointageOK)
            {
                alertDialog.setMessage("Pointage effectuté");
                isPointageOK = false;
                isSalleOK = false;
                alertDialog.setButton("OK", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        //Log.e("Pointage NOT OK OK: ", "");
                    }
                });
                alertDialog.show();
            }
            else if(!isSalleOK){
                alertDialog.setMessage("Veuillez vérifier votre emploi du temps");
                isSalleOK=true;
                alertDialog.setButton("OK", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        //Log.e("Pointage NOT OK OK: ", "");
                    }
                });
                alertDialog.show();
            }
        }
    }

    private String readFromIntent(Intent intent) {
        String action = intent.getAction();
        String tagText = "";
        if (NfcAdapter.ACTION_TAG_DISCOVERED.equals(action)
                || NfcAdapter.ACTION_TECH_DISCOVERED.equals(action)
                || NfcAdapter.ACTION_NDEF_DISCOVERED.equals(action)) {
            Parcelable[] rawMsgs = intent.getParcelableArrayExtra(NfcAdapter.EXTRA_NDEF_MESSAGES);
            NdefMessage[] msgs = null;
            if (rawMsgs != null) {
                msgs = new NdefMessage[rawMsgs.length];
                for (int i = 0; i < rawMsgs.length; i++) {
                    msgs[i] = (NdefMessage) rawMsgs[i];
                }
            }
            tagText = buildTagViews(msgs);
        }
        return tagText;
    }

    private String buildTagViews(NdefMessage[] msgs) {
        if (msgs == null || msgs.length == 0) return "";

        String text = "";
//        String tagId = new String(msgs[0].getRecords()[0].getType());
        byte[] payload = msgs[0].getRecords()[0].getPayload();
        String textEncoding = ((payload[0] & 128) == 0) ? "UTF-8" : "UTF-16"; // Get the Text Encoding
        int languageCodeLength = payload[0] & 0063; // Get the Language Code, e.g. "en"
        // String languageCode = new String(payload, 1, languageCodeLength, "US-ASCII");

        try {
            // Get the Text
            text = new String(payload, languageCodeLength + 1, payload.length - languageCodeLength - 1, textEncoding);
        } catch (UnsupportedEncodingException e) {
            Log.e("UnsupportedEncoding", e.toString());
        }

        //tvNFCContent.setText("NFC Content: " + text);
        // Toast.makeText(getApplicationContext(), "Numero de la salle "+text, Toast.LENGTH_LONG).show();
        return text;

    }

    /**
     * Slide menu item click listener
     * */
    private class SlideMenuClickListener implements
            ListView.OnItemClickListener {
        @Override
        public void onItemClick(AdapterView<?> parent, View view, int position,
                                long id) {
            // display view for selected nav drawer item
            displayView(position);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // toggle nav drawer on selecting action bar app icon/title
        if (mDrawerToggle.onOptionsItemSelected(item)) {
            return true;
        }
        // Handle action bar actions click
        switch (item.getItemId()) {
            case R.id.action_settings:
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    /***
     * Called when invalidateOptionsMenu() is triggered
     */
    @Override
    public boolean onPrepareOptionsMenu(Menu menu) {
        // if nav drawer is opened, hide the action items
        boolean drawerOpen = mDrawerLayout.isDrawerOpen(mDrawerList);
        menu.findItem(R.id.action_settings).setVisible(!drawerOpen);
        return super.onPrepareOptionsMenu(menu);
    }

    /**
     * Diplaying fragment view for selected nav drawer list item
     * */
    private void displayView(int position) {
        // update the main content by replacing fragments
        Fragment fragment = null;
        switch (position) {
            case 0:
                fragment = new HomeFragment();
                break;
            case 1:
                fragment = new ListePointageFragment();
                break;
            default:
                break;
        }

        if (fragment != null) {
            FragmentManager fragmentManager = getFragmentManager();
            fragmentManager.beginTransaction().replace(R.id.frame_container, fragment).commit();

            // update selected item and title, then close the drawer
            mDrawerList.setItemChecked(position, true);
            mDrawerList.setSelection(position);
            setTitle(navMenuTitles[position]);
            mDrawerLayout.closeDrawer(mDrawerList);
        } else {
            // error in creating fragment
            Log.e("MainActivity", "Error in creating fragment");
        }
    }

    @Override
    public void setTitle(CharSequence title) {
        mTitle = title;
        getSupportActionBar().setTitle(mTitle);
    }

    /**
     * When using the ActionBarDrawerToggle, you must call it during
     * onPostCreate() and onConfigurationChanged()...
     */

    @Override
    protected void onPostCreate(Bundle savedInstanceState) {
        super.onPostCreate(savedInstanceState);
        // Sync the toggle state after onRestoreInstanceState has occurred.
        mDrawerToggle.syncState();
    }

    @Override
    public void onConfigurationChanged(Configuration newConfig) {
        super.onConfigurationChanged(newConfig);
        // Pass any configuration change to the drawer toggls
        mDrawerToggle.onConfigurationChanged(newConfig);
    }
}
