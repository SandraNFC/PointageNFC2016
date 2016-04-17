package fragments;


import android.app.AlertDialog;
import android.app.DatePickerDialog;
import android.app.Fragment;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.database.Cursor;
import android.nfc.NdefMessage;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Parcelable;
import android.project.nfc.nfcpointagev1.R;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.GridView;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.SimpleCursorAdapter;
import android.widget.TextView;
import android.widget.Toast;

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

import service.ServiceHandler;
import sessions.SessionManager;
import urls.Url;


/**
 * A simple {@link Fragment} subclass.
 */
public class HomeFragment extends Fragment implements View.OnClickListener{

    private ProgressDialog pDialog;


    public static final String IMAGE_RESOURCE_ID = "iconResourceID";
    public static final String ITEM_NAME = "itemName";

    SimpleCursorAdapter dataAdapter;
    private ListView maListView;

    private static final String TAG_IDSC = "IDSC";
    //private static final String TAG_IDEC = "idec";
    private static final String TAG_IDCOURS = "IDCOURS";
    private static final String TAG_IDPROMOTION = "IDPROMOTION";
    private static final String TAG_PROMOTION = "PROMOTION";
    private static final String TAG_IDSALLE = "IDSALLE";
    //private static final String TAG_IDUSER = "iduser";
    private static final String TAG_HEUREENTREE = "HEUREENTREE";
    private static final String TAG_HEURESORTIE = "HEURESORTIE";
    private static final String TAG_NUMSALLE = "NUMSALLE";
    private static final String TAG_COURS = "COURS";
    //private static final String TAG_NOM = "nom";
    //private static final String TAG_LOGIN = "login";

    private AdapterView.OnItemSelectedListener listener;

    ArrayList<HashMap<String, String>> emploisDutempsDuJours;

    ListView homegrid;

    EditText dateText, todateText;
    Button btnSearch;

    // session
    SessionManager session;

    ServiceHandler sh;

    String idEtudiant="";
    String idPromotion="";


    Date currentDate;

    AlertDialog alertDialog;
    SimpleDateFormat dateFormat = new SimpleDateFormat("dd MMM yyyy HH:mm");
    DateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
    DateFormat form = new SimpleDateFormat("yyyy-MM-dd");

    private DatePickerDialog fromDatePickerDialog, toDatePickerDialog;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        // inflate the root view of the fragment
        View fragmentView = inflater.inflate(R.layout.fragment_home, container, false);
        homegrid = (ListView) fragmentView.findViewById(R.id.gridviewHome);

        // recherche

        dateText = (EditText) fragmentView.findViewById(R.id.fromDate);
        todateText = (EditText) fragmentView.findViewById(R.id.toDate);
        btnSearch = (Button) fragmentView.findViewById(R.id.btnFiltreDate);

        /* Alert dialog */
        alertDialog = new AlertDialog.Builder(getActivity()).create();

        /* Session */
        session = new SessionManager(getActivity());

        session.checkLogin();

        sh = new ServiceHandler();

        HashMap<String, String> etudiant = session.getUserDetails();

        idEtudiant = etudiant.get(SessionManager.KEY_IDUSER);
        idPromotion = etudiant.get(SessionManager.KEY_NAME);


        if(dateText.getText().toString().trim().length()==0 && todateText.getText().toString().trim().length() ==0){
            new EmploisDuTemp().execute();
        }

        dateText.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    setDateTimeField();
                    fromDatePickerDialog.show();
                    Log.e("CLICK: ","CLICK");
                }
            });
        todateText.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                setDateTimeField();
                toDatePickerDialog.show();
            }
        });
        btnSearch.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    // filtre
                    new RechercheEmloiDuTemps().execute();
                }
        });


        return fragmentView;
    }

    private void setDateTimeField() {
        dateText.setOnClickListener(this);
        todateText.setOnClickListener(this);

        Calendar newCalendar = Calendar.getInstance();
        fromDatePickerDialog = new DatePickerDialog(getActivity(), new DatePickerDialog.OnDateSetListener() {

            public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                Calendar newDate = Calendar.getInstance();
                newDate.set(year, monthOfYear, dayOfMonth);
                dateText.setText(form.format(newDate.getTime()));
            }

        },newCalendar.get(Calendar.YEAR), newCalendar.get(Calendar.MONTH), newCalendar.get(Calendar.DAY_OF_MONTH));

        toDatePickerDialog = new DatePickerDialog(getActivity(), new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                Calendar newDate = Calendar.getInstance();
                newDate.set(year, monthOfYear, dayOfMonth);
                todateText.setText(form.format(newDate.getTime()));
            }
        },newCalendar.get(Calendar.YEAR), newCalendar.get(Calendar.MONTH), newCalendar.get(Calendar.DAY_OF_MONTH));
    }


    @Override
    public void onClick(View v) {
        if(v == dateText) {
            fromDatePickerDialog.show();
        }
        else if(v == todateText)
        {
            toDatePickerDialog.show();
        }
    }

    class EmploisDuTemp extends AsyncTask<String, String, String>
    {

        /* Emplois du temps du jours */

        Calendar cal = Calendar.getInstance();

        @Override
        protected String doInBackground(String... params) {

            currentDate = cal.getTime();

            emploisDutempsDuJours = new ArrayList<HashMap<String, String>>();





            try {
                String json = sh.makeServiceCall(Url.URL_EMPLPOI_DU_TEMP,ServiceHandler.GET);
                JSONArray jArray = new JSONArray(json);

                for(int i=0;i<jArray.length();i++)
                {
                    HashMap<String,String> emploisDutemps = new HashMap<String,String>();

                    JSONObject jObject = jArray.getJSONObject(i);
                    Date dateEntree = sdf.parse(jObject.getString(TAG_HEUREENTREE));
                    Date dateSortie = sdf.parse(jObject.getString(TAG_HEURESORTIE));

                    String currentDateWithoutHours = form.format(currentDate);
                    //Date currDate = form.parse(currentDateWithoutHours);

                    String dateEntreeWithoutHours = form.format(dateEntree);

                    if(idPromotion.equals(jObject.getString(TAG_IDPROMOTION)))
                    {
                        //Toast.makeText(getActivity()," ID USER "+jObject.getString("iduser"),Toast.LENGTH_LONG).show();
                        if(currentDateWithoutHours.equals(dateEntreeWithoutHours))
                        {
                            // Log.e("Date entree: ",dateEntree.toString());

                            // Log.e("CURRENT DATE: ",currentDate.toString());
                            emploisDutemps.put(TAG_NUMSALLE,jObject.getString(TAG_NUMSALLE));
                            emploisDutemps.put(TAG_COURS,jObject.getString(TAG_COURS));
                            emploisDutemps.put(TAG_HEUREENTREE,dateFormat.format(dateEntree));
                            emploisDutemps.put(TAG_HEURESORTIE,dateFormat.format(dateSortie));

                            emploisDutempsDuJours.add(emploisDutemps);
                        }
                        else{
                            emploisDutemps.put(TAG_NUMSALLE,"");
                            emploisDutemps.put(TAG_COURS,"Pas de cours prévu pour aujourd'hui");
                            emploisDutemps.put(TAG_HEUREENTREE,"");
                            emploisDutemps.put(TAG_HEURESORTIE, "");
                        }
                    }
                }
            } catch (JSONException e) {
                e.printStackTrace();
            } catch (ParseException e) {
                e.printStackTrace();
            }


            //ArrayAdapter<String> adapter = new ArrayAdapter<String>(getActivity(), R.layout.emplois_du_temps,new int[]{R.id.salle, R.id.cours, R.id.heureDebut, R.id.heureFin}, emploisDutempsDuJours);

            /*ListAdapter adapter = new SimpleAdapter(getActivity(),emploisDutempsDuJours, R.layout.emplois_du_temps, new String[]{TAG_NUMSALLE,TAG_COURS,TAG_HEUREENTREE,TAG_HEURESORTIE}, new int[]{R.id.salle, R.id.cours, R.id.heureDebut, R.id.heureFin});
            homegrid.setAdapter(adapter);*/

            return null;
        }

        @Override
        protected void onPostExecute(String file_url) {
            super.onPostExecute(file_url);
            // Dismiss the progress dialog
            ListAdapter adapter = new SimpleAdapter(getActivity(),emploisDutempsDuJours, R.layout.emplois_du_temps, new String[]{TAG_NUMSALLE,TAG_COURS,TAG_HEUREENTREE,TAG_HEURESORTIE}, new int[]{R.id.salle, R.id.cours, R.id.heureDebut, R.id.heureFin});
            homegrid.setAdapter(adapter);

        }
    }

    class RechercheEmloiDuTemps extends AsyncTask<String,String,String>
    {
        String fromDate = dateText.getText().toString();
        String toDate = todateText.getText().toString();

        @Override
        protected String doInBackground(String... params) {
            emploisDutempsDuJours = new ArrayList<HashMap<String, String>>();

            try{
                String json = sh.makeServiceCall(Url.URL_EMPLPOI_DU_TEMP,ServiceHandler.GET);
                JSONArray jArray = new JSONArray(json);

                /* Date fromDateD = form.parse(fromDate);
                Date toDateD = form.parse(toDate);


                String fromDateWithoutHours = form.format(fromDateD);
                String toDateWithoutHours = form.format(toDateD); */

                for(int i=0;i<jArray.length();i++)
                {
                    JSONObject jObject = jArray.getJSONObject(i);

                    if(idPromotion.equals(jObject.getString(TAG_IDPROMOTION)))
                    {

                        //Log.e("ID Promotion: ",idPromotion);
                        String heureEntreeWithoutHours = form.format(sdf.parse(jObject.getString(TAG_HEUREENTREE)));

                        Date dateEntree = form.parse(jObject.getString(TAG_HEUREENTREE));

                        if(fromDate.trim().length() == 0 && toDate.trim().length() == 0) // TOUS
                        {
                            //Log.e("FROM DATE: ","VIDE");
                            HashMap<String,String> emploiDuTemp = new HashMap<String,String>();
                            emploiDuTemp.put(TAG_COURS,jObject.getString(TAG_COURS));
                            emploiDuTemp.put(TAG_NUMSALLE,jObject.getString(TAG_NUMSALLE));
                            emploiDuTemp.put(TAG_HEUREENTREE,dateFormat.format(sdf.parse(jObject.getString(TAG_HEUREENTREE))));
                            emploiDuTemp.put(TAG_HEURESORTIE,dateFormat.format(sdf.parse(jObject.getString(TAG_HEURESORTIE))));

                            //Log.e("FROM DATE VIDE: ", jObject.getString(TAG_HEUREENTREE));

                            emploisDutempsDuJours.add(emploiDuTemp);

                        }
                        else if(fromDate.trim().length() > 0 && toDate.trim().length() == 0) // recherche à partir de
                        {
                            Date fromDateD = form.parse(fromDate);
                           // if(fromDate.equals(heureEntreeWithoutHours))
                            //{
                                Log.e("ATO:","FROM DATE A PARTIR DE "+fromDateD.toString()+" "+dateEntree);
                                if (fromDate.equals(heureEntreeWithoutHours) || fromDateD.before(dateEntree)) {
                                    Log.e("A PARTIR DE:"," ");
                                    HashMap<String, String> emploiDuTemp = new HashMap<String, String>();
                                    emploiDuTemp.put(TAG_COURS, jObject.getString(TAG_COURS));
                                    emploiDuTemp.put(TAG_NUMSALLE, jObject.getString(TAG_NUMSALLE));
                                    emploiDuTemp.put(TAG_HEUREENTREE,dateFormat.format(sdf.parse(jObject.getString(TAG_HEUREENTREE))));
                                    emploiDuTemp.put(TAG_HEURESORTIE,dateFormat.format(sdf.parse(jObject.getString(TAG_HEURESORTIE))));

                                    emploisDutempsDuJours.add(emploiDuTemp);
                                }
                            //}
                        }
                        else if(fromDate.trim().length() == 0 && toDate.trim().length() > 0) // recherche jusqu'à ...
                        {
                            Date todateD = form.parse(toDate);
                            //if(toDate.equals(heureEntreeWithoutHours))
                            //{
                                if(toDate.equals(heureEntreeWithoutHours) || todateD.after(dateEntree))
                                {
                                    Log.e("JUSQU'A: ", " ");
                                    HashMap<String, String> emploiDuTemp = new HashMap<String, String>();
                                    emploiDuTemp.put(TAG_COURS, jObject.getString(TAG_COURS));
                                    emploiDuTemp.put(TAG_NUMSALLE, jObject.getString(TAG_NUMSALLE));
                                    emploiDuTemp.put(TAG_HEUREENTREE,dateFormat.format(sdf.parse(jObject.getString(TAG_HEUREENTREE))));
                                    emploiDuTemp.put(TAG_HEURESORTIE,dateFormat.format(sdf.parse(jObject.getString(TAG_HEURESORTIE))));

                                    emploisDutempsDuJours.add(emploiDuTemp);
                                }
                            //}
                        }
                        else if(fromDate.trim().length() > 0 && toDate.trim().length() > 0) // recherche de ... jusqu'à ...
                        {
                            //Log.e("TO DATE: ","NON VIDE");
                            Date fromDateD = form.parse(fromDate);
                            Date todateD = form.parse(toDate);
                            //if(fromDateD.equals(dateEntree) || todateD.equals(dateEntree))
                            //{

                                if(fromDateD.equals(dateEntree) || todateD.equals(dateEntree) || dateEntree.after(fromDateD) && dateEntree.before(todateD)) // OK
                                {
                                    HashMap<String,String> emploiDuTemp = new HashMap<String,String>();

                                    emploiDuTemp.put(TAG_COURS, jObject.getString(TAG_COURS));
                                    emploiDuTemp.put(TAG_NUMSALLE, jObject.getString(TAG_NUMSALLE));
                                    emploiDuTemp.put(TAG_HEUREENTREE,dateFormat.format(sdf.parse(jObject.getString(TAG_HEUREENTREE))));
                                    emploiDuTemp.put(TAG_HEURESORTIE,dateFormat.format(sdf.parse(jObject.getString(TAG_HEURESORTIE))));
                                    emploisDutempsDuJours.add(emploiDuTemp);

                                    //emploisDutempsDuJours.add(emploiDuTemp);
                                }
                                /*else if(todateD.equals(dateEntree) || dateEntree.before(todateD))
                                {
                                    Log.e("ICI ", " ");
                                    //HashMap<String,String> emploiDuTemp = new HashMap<String,String>();
                                    emploiDuTemp.put(TAG_COURS, jObject.getString(TAG_COURS));
                                    emploiDuTemp.put(TAG_NUMSALLE, jObject.getString(TAG_NUMSALLE));
                                    emploiDuTemp.put(TAG_HEUREENTREE, jObject.getString(TAG_HEUREENTREE));
                                    emploiDuTemp.put(TAG_HEURESORTIE, jObject.getString(TAG_HEURESORTIE));

                                    //emploisDutempsDuJours.add(emploiDuTemp);
                                }*/

                            //}
                        }
                    }
                }


            } catch (JSONException e) {
                e.printStackTrace();
            } catch (ParseException e) {
                e.printStackTrace();
            }
            return null;
        }

        @Override
        protected void onPostExecute(String file_url) {
            super.onPostExecute(file_url);
            // Dismiss the progress dialog
            ListAdapter adapter = new SimpleAdapter(getActivity(),emploisDutempsDuJours, R.layout.emplois_du_temps, new String[]{TAG_NUMSALLE,TAG_COURS,TAG_HEUREENTREE,TAG_HEURESORTIE}, new int[]{R.id.salle, R.id.cours, R.id.heureDebut, R.id.heureFin});
            homegrid.setAdapter(adapter);

        }
    }
}
