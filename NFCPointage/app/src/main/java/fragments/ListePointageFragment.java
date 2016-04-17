package fragments;


import android.app.DatePickerDialog;
import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import android.project.nfc.nfcpointagev1.R;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.List;

import service.ServiceHandler;
import sessions.SessionManager;
import urls.Url;

/**
 * A simple {@link Fragment} subclass.
 */
public class ListePointageFragment extends Fragment implements View.OnClickListener{


    SessionManager session;

    String idEtudiant = "";
    String idPromotion = "";

    ArrayList<HashMap<String, String>> listePresence;

    ListView listViewPointage;

    ServiceHandler sh;

    private EditText fromDateEtxt;
    private Button btnFiltreDate;

    private DatePickerDialog fromDatePickerDialog;

    // DatePickerDialog dateSearch;

    // TAG
    private static final String TAG_IDSC = "IDSC";
    private static final String TAG_IDETUDIANT = "IDETUDIANT";
    private static final String TAG_IDPOINTAGE = "IDPOINTAGE";
    private static final String TAG_IDCOURS = "IDCOURS";
    private static final String TAG_IDPROMOTION = "IDPROMOTION";
    private static final String TAG_PROMOTION = "PROMOTION";
    private static final String TAG_IDSALLE = "IDSALLE";
    private static final String TAG_DEBUTCOURS = "HEUREENTREE";
    private static final String TAG_FINCOURS = "HEURESORTIE";
    private static final String TAG_NUMSALLE = "NUMSALLE";
    private static final String TAG_COURS = "COURS";
    private static final String TAG_NOM = "NOM";
    private static final String TAG_PRENOM = "PRENOM";
    private static final String TAG_LOGIN = "PSEUDO";
    private static final String TAG_HEUREENTREE = "HEUREENTREEETUDIANT";


    DateFormat df, dfwithouthours;

    SimpleDateFormat dateFormat = new SimpleDateFormat("dd MMM yyyy HH:mm");
    SimpleDateFormat dateForm = new SimpleDateFormat("dd MMM yyyy");


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_liste_pointage, container, false);

        session = new SessionManager(getActivity());
        session.checkLogin();

        HashMap<String,String> etudiant = session.getUserDetails();

        idEtudiant = etudiant.get(SessionManager.KEY_IDUSER);
        idPromotion = etudiant.get(SessionManager.KEY_NAME);

        listViewPointage = (ListView) view.findViewById(R.id.listepointage);


        //listePresence = new ArrayList<HashMap<String, String>>();

        // datepicker

        df =new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        dfwithouthours = new SimpleDateFormat("yyyy-MM-dd");

        fromDateEtxt = (EditText)view.findViewById(R.id.filtreParDate);
        btnFiltreDate = (Button) view.findViewById(R.id.btnFiltreDate);



        fromDateEtxt.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                setDateTimeField();
                fromDatePickerDialog.show();
                Log.e("ATO @CLICK: ", "CLICK");

            }
        });

        btnFiltreDate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //new ListPointageEtudiant().execute();
                new FiltrePresenceEtudiant().execute();
            }
        });

        if(fromDateEtxt.getText().toString().trim().length() == 0)
        {
            Log.e("Taille from date text: ",String.valueOf(fromDateEtxt.getText().toString().trim().length()));
            new ListPointageEtudiant().execute();
        }

        return view;
    }

    private void setDateTimeField() {
        fromDateEtxt.setOnClickListener(this);


        Calendar newCalendar = Calendar.getInstance();
        fromDatePickerDialog = new DatePickerDialog(getActivity(), new DatePickerDialog.OnDateSetListener() {

            public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                Calendar newDate = Calendar.getInstance();
                newDate.set(year, monthOfYear, dayOfMonth);
                fromDateEtxt.setText(dfwithouthours.format(newDate.getTime()));
            }

        },newCalendar.get(Calendar.YEAR), newCalendar.get(Calendar.MONTH), newCalendar.get(Calendar.DAY_OF_MONTH));
    }

    @Override
    public void onClick(View v) {
        if(v == fromDateEtxt) {
            fromDatePickerDialog.show();
        }

    }

    private class ListPointageEtudiant extends AsyncTask<String, String, String>
    {

        //String dateText = fromDateEtxt.getText().toString();


        @Override
        protected String doInBackground(String... s) {

            sh = new ServiceHandler();

            listePresence = new ArrayList<HashMap<String, String>>();

            /*List<NameValuePair> params = new ArrayList<NameValuePair>();
            params.add(new BasicNameValuePair("idp",dateText));*/

            try {

                String json = sh.makeServiceCall(Url.URL_LIST_POINTAGE,ServiceHandler.GET);

                Log.e("JSON liste presence: ",json);

                JSONArray jArray = new JSONArray(json);
                int j=0;
                for(int i=0;i<jArray.length();i++)
                {

                    JSONObject jObject = jArray.getJSONObject(i);
                    HashMap<String,String> lPresence = new HashMap<String,String>();

                    if(idEtudiant.equals(jObject.getString(TAG_IDETUDIANT)))
                    {

                        lPresence.put("idetudiant",jObject.getString(TAG_IDETUDIANT));
                        lPresence.put("idcours",jObject.getString(TAG_IDCOURS));
                        lPresence.put("nom",jObject.getString(TAG_NOM));
                        lPresence.put("login",jObject.getString(TAG_LOGIN));
                        lPresence.put("cours",jObject.getString(TAG_COURS));
                        lPresence.put("heureEntree",dateFormat.format(df.parse(jObject.getString(TAG_HEUREENTREE))));
                        lPresence.put("debutCours",dateFormat.format(df.parse(jObject.getString(TAG_DEBUTCOURS))));
                        lPresence.put("finCours",dateFormat.format(df.parse(jObject.getString(TAG_FINCOURS))));
                        lPresence.put("situation","Présent(e)");

                        listePresence.add(lPresence);
                            //j++;
                        }
                    else{
                            Log.e("ATO: ",idEtudiant);
                    }
                }


            }
            catch (JSONException e) {
                e.printStackTrace();
            } catch (ParseException e) {
                e.printStackTrace();
            }

            return null;
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);
            // Dismiss the progress dialog
            ListAdapter adapter = new SimpleAdapter(getActivity(),listePresence, R.layout.pointage_liste, new String[]{"debutCours","finCours","situation"}, new int[]{R.id.dateDebut, R.id.dateFin, R.id.situation});
            listViewPointage.setAdapter(adapter);
        }
    }

    private class FiltrePresenceEtudiant extends AsyncTask<String, String, String>
    {
        String dateText = fromDateEtxt.getText().toString();
        @Override
        protected String doInBackground(String... params) {
            sh = new ServiceHandler();

            /*List<NameValuePair> params = new ArrayList<NameValuePair>();
            params.add(new BasicNameValuePair("idp",dateText));*/
            listePresence = new ArrayList<HashMap<String, String>>();

            try {

                String json = sh.makeServiceCall(Url.URL_LIST_POINTAGE, ServiceHandler.GET);

                Log.e("JSON liste presence: ", json);

                JSONArray jArray = new JSONArray(json);
                int j = 0;
                for (int i = 0; i < jArray.length(); i++) {
                    JSONObject jObject = jArray.getJSONObject(i);
                    if (idEtudiant.equals(jObject.getString(TAG_IDETUDIANT))) {
                        if (dateText.trim().length() > 0) {
                            Date dateRecherche = dfwithouthours.parse(dateText);
                            Date dateDebut = df.parse(jObject.getString(TAG_DEBUTCOURS));
                            Date dateFin = df.parse(jObject.getString(TAG_FINCOURS));

                            // only Date
                            String dateRechercheWithoutHours = dfwithouthours.format(dateRecherche);
                            String dateDebutWithoutHours = dfwithouthours.format(dateDebut);

                            // Log.e("Date debut: ",dateDebut.toString()+"Date fin: "+dateFin.toString()+" Date filtre: "+dateRecherche);
                            if (dateRechercheWithoutHours.equals(dateDebutWithoutHours) || dateRecherche.after(dateDebut) && dateRecherche.before(dateFin)) {
                                Log.e("TAILLE: ",String.valueOf(i));

                                HashMap<String, String> lPresence = new HashMap<String, String>();
                                lPresence.put("idetudiant", jObject.getString(TAG_IDETUDIANT));
                                lPresence.put("idcours", jObject.getString(TAG_IDCOURS));
                                lPresence.put("nom", jObject.getString(TAG_NOM));
                                lPresence.put("login", jObject.getString(TAG_LOGIN));
                                lPresence.put("cours", jObject.getString(TAG_COURS));
                                lPresence.put("heureEntree",dateFormat.format(df.parse(jObject.getString(TAG_HEUREENTREE))));
                                lPresence.put("debutCours",dateFormat.format(df.parse(jObject.getString(TAG_DEBUTCOURS))));
                                lPresence.put("finCours",dateFormat.format(df.parse(jObject.getString(TAG_FINCOURS))));
                                lPresence.put("situation", "Présent(e)");

                                listePresence.add(lPresence);
                                //j++;
                            } else {
                                // Log.e("Format date: ",df.parse(dateText).toString());

                                HashMap<String, String> lPresence = new HashMap<String, String>();
                                lPresence.put("idetudiant", jObject.getString(TAG_IDETUDIANT));
                                lPresence.put("idcours", jObject.getString(TAG_IDCOURS));
                                lPresence.put("nom", jObject.getString(TAG_NOM));
                                lPresence.put("login", jObject.getString(TAG_LOGIN));
                                lPresence.put("cours", jObject.getString(TAG_COURS));
                                //lPresence.put("heureEntree", jObject.getString(TAG_HEUREENTREE));
                                lPresence.put("debutCours", dateForm.format(dfwithouthours.parse(dateText)));
                                //lPresence.put("finCours", jObject.getString(TAG_FINCOURS));
                                lPresence.put("situation", "Absent(e) ou Pas de cours");

                                listePresence.add(lPresence); break;
                            }
                        } else {

                            HashMap<String, String> lPresence = new HashMap<String, String>();
                            lPresence.put("idetudiant", jObject.getString(TAG_IDETUDIANT));
                            lPresence.put("idcours", jObject.getString(TAG_IDCOURS));
                            lPresence.put("nom", jObject.getString(TAG_NOM));
                            lPresence.put("login", jObject.getString(TAG_LOGIN));
                            lPresence.put("cours", jObject.getString(TAG_COURS));
                            lPresence.put("heureEntree",dateFormat.format(df.parse(jObject.getString(TAG_HEUREENTREE))));
                            lPresence.put("debutCours",dateFormat.format(df.parse(jObject.getString(TAG_DEBUTCOURS))));
                            lPresence.put("finCours",dateFormat.format(df.parse(jObject.getString(TAG_FINCOURS))));
                            lPresence.put("situation", "Présent(e)");

                            listePresence.add(lPresence);
                            //j++;
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
        protected void onPostExecute(String result) {
            super.onPostExecute(result);
            // Dismiss the progress dialog
            ListAdapter adapter = new SimpleAdapter(getActivity(),listePresence, R.layout.pointage_liste, new String[]{"debutCours","finCours","situation"}, new int[]{R.id.dateDebut, R.id.dateFin, R.id.situation});
            listViewPointage.setAdapter(adapter);
        }
    }


}
