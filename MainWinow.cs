/*
 *   Project Supervisor: Sayed Rezwanul Haque (Nabil)
 *   Co-Supervisor: Robi Kormokar 
 *   MU Drone Control Station
 * 
 */

using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.IO.Ports;
using System.Threading;
using System.IO;


namespace AvionicsInstrumentControlDemo
{
    public partial class MainWindow : Form
    {
        String data;
        String portSelection;
        String baudRate;

        int heading = 0;
        int roll = 0;
        int pitch = 0;


        /*
        double lat = 24.896984;
        double lon = 91.867949;
        */
        double lat = 23.8156824;
        double lon = 90.4276896;


        int zoom = 16;
        
        String city_name = "Dhaka";
        String country_name = "Bangladesh";

        private bool connectButton = false;

        public MainWindow()
        {
            InitializeComponent();

            loadMap(lat,lon,zoom);

            scanComports();

        }

        void scanComports()
        {
            String[] ports = SerialPort.GetPortNames();

            foreach (String port in ports)
            {
                comboBox1.Items.Add(port);
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            if (serialPort1.IsOpen == true)
            {
                serialPort1.Close();
                serialPort1.Dispose();
            }
            Close();
        }

        
        private void button3_Click(object sender, EventArgs e)
        {
            serialPort1.Write("0");
        }

        private void serialPort1_DataReceived(object sender, SerialDataReceivedEventArgs e)
        {
            try
            {

                data = serialPort1.ReadLine();

                textBox1.Text = data.ToString();

                String[] offsets = data.Split(',');

                int index = 0;

                foreach (String offset in offsets)
                {
                    if (index == 0)
                    {
                        label11.Text = offset;
                        roll = Convert.ToInt16(offset);
                    }

                    else if (index == 1)
                    {
                        label12.Text = offset;
                        pitch = Convert.ToInt16(offset);
                    }

                    else if (index == 2)
                    {
                        label13.Text = offset;
                        heading = Convert.ToInt16(offset);
                    }

                    else if (index == 3)
                    {
                        label2.Text = offset;
                    }

                    else if (index == 4)
                    {
                         label1.Text = offset;
                    }
                  //  else if (index == 5) label16.Text = lat.ToString();
                  //  else if (index == 6) label17.Text = lon.ToString();
                  //  else if (index == 7) ;//label18.Text = offset;

                    index++;
                }

                headingIndicatorInstrumentControl1.SetHeadingIndicatorParameters(heading+180);
                horizonInstrumentControl1.SetAttitudeIndicatorParameters(pitch, roll);
                turnCoordinatorInstrumentControl1.SetTurnCoordinatorParameters(roll,roll);
            }
            catch (UnauthorizedAccessException)
            {
                MessageBox.Show("Not Available!!!");
            }
        }

        private void comboBox1_SelectedIndexChanged(object sender, EventArgs e)
        {
               // scanComports();
                portSelection = comboBox1.Text;
                serialPort1.PortName = portSelection;   
        }

        private void comboBox2_SelectedIndexChanged(object sender, EventArgs e)
        {
                baudRate = comboBox2.Text;
                serialPort1.BaudRate = Convert.ToInt32(baudRate);
        }


      

        private void exitToolStripMenuItem_Click(object sender, EventArgs e)
        {
            endCommunication();
            Application.Exit();
        }

        private void aboutUsToolStripMenuItem_Click(object sender, EventArgs e)
        {
            MessageBox.Show("MU and SUST Drone Team\n");
        }

        private void startToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (serialPort1.IsOpen == false)
            {
                MessageBox.Show("Not Connceted!!!");
            }
            else
            {
                if (comboBox1.Text == "")
                {
                    MessageBox.Show("Select Port");
                }
                else if (comboBox2.Text == "")
                {
                    MessageBox.Show("Select Baud Rate");
                }
                else
                {
                    serialPort1.Write("1");
                }
            }
        }

        private void pauseToolStripMenuItem_Click(object sender, EventArgs e)
        {

            if (serialPort1.IsOpen == false)
            {
                MessageBox.Show("Not Connceted!!!");
            }
            else
            {
                //scanComports();

                if (comboBox1.Text == "")
                {
                    MessageBox.Show("Select Port");
                }
                else if (comboBox2.Text == "")
                {
                    MessageBox.Show("Slect Baud Rate");
                }
                else
                {
                    serialPort1.Write("0");
                }
            }
        }

        void initializedCommunication()
        {
            try
            {
                serialPort1.Close();
                serialPort1.Dispose();

                if (comboBox1.Text == "" || comboBox2.Text == "")
                {
                    if (comboBox1.Text == "" || comboBox2.Text == "") MessageBox.Show("Select Port and buat rate");
                    else if (comboBox1.Text == "") MessageBox.Show("Select Port");
                    else if (comboBox2.Text == "") MessageBox.Show("Select Baud rate");
                }
                else
                {
                    serialPort1.Open();
                    CheckForIllegalCrossThreadCalls = false;
                }

                if (serialPort1.IsOpen == true)
                {
                    MessageBox.Show("Port is Attacthed!!!");
                }
                else
                {
                    return;
                }
            }
            catch (UnauthorizedAccessException)
            {
                MessageBox.Show("Unauthorized!!!");
            }
        }

        void endCommunication()
        {
            MessageBox.Show("Port is Dettacthed!!!");
            serialPort1.Write("0");
            serialPort1.Close();
            serialPort1.Dispose();
        }

        private void emailUsToolStripMenuItem_Click(object sender, EventArgs e)
        {
            MessageBox.Show("info@drone.com");
        }

        private void button1_Click_1(object sender, EventArgs e)
        {
            loadMap(lat,lon,10);

            /*
            MapWindow mapWindow = new MapWindow();
            mapWindow.Show();
             */
        }

        void loadMap(double lat,double lon, int zoom)
        {
           webBrowser6.Navigate("http://localhost/DoneTest/Justweather.php?lat=" + lat.ToString() + "&" + "lon=" + lon.ToString() + "&" + "zoom=" + zoom);
           
           webBrowser5.Navigate("http://localhost/DoneTest/weather.php?lat=" + lat.ToString() + "&" + "lon=" + lon.ToString() + "&" + "zoom=" + zoom);

           webBrowser1.Navigate("http://map.comlu.com/openweathermap/?zoom=10&lat=23.8156824&lon=90.4276896&layers=B0FTTFF");

           //webBrowser2.Navigate("http://api.openweathermap.org/data/2.5/weather?lat=23.8156824&lon=90.4276896&mode=html&appid=9625d5a354fb59b48949b112091f6b69");

           webBrowser3.Navigate("http://localhost/DoneTest/HourlyTest.php?city=" + city_name + "&country=" + country_name);

           webBrowser4.Navigate("http://map.comlu.com/openweathermap/?zoom=2 &lat=23.8156824&lon=90.4276896&layers=B0FTTFF");

           webBrowser7.Navigate("http://localhost/mapcircle/example.php");

           //webBrowser2.Navigate("http://api.openweathermap.org/data/2.5/weather?q=London&mode=html&appid=9625d5a354fb59b48949b112091f6b69");
           //webBrowser1.Navigate("file:///E:/Drone%20project/MyCsharpProjects/AvionicsInstrumentControlDemo/index.html");
           // webBrowser1.Navigate("https://maps.googleapis.com/maps/api/staticmap?maptype=satellite&center="+lat.ToString()+","+lon.ToString()+"&zoom="+zoom.ToString()+"&size=640x400&key=AIzaSyC9b2I56KbyL_enSxwu4DYBXSjpPun-0f0");
        }

        private void button2_Click(object sender, EventArgs e)
        {

            if (connectButton == false)
            {
                initializedCommunication();
                
                if (serialPort1.IsOpen == true && comboBox1.Text != "" && comboBox2.Text !="")
                {
                    button2.Text = "Disconncet";
                    button2.ForeColor = Color.YellowGreen;
                    connectButton = true;
                }
                else if(comboBox1.Text == "")
                {
                 //   MessageBox.Show("Select Comport or baud rate");
                    scanComports();
                }
            }
            else
            {
                button2.Text = "Connect";
                button2.ForeColor = Color.Red;
                endCommunication();
                connectButton = false;
            }
            
        }

        private void button1_Click_2(object sender, EventArgs e)
        {
            for (int i = 0; i <= 90; i++)
            {
                turnCoordinatorInstrumentControl1.SetTurnCoordinatorParameters(i,i);
             
            }
        }

        private void button1_Click_3(object sender, EventArgs e)
        {
            if(zoom<20.0)zoom = zoom + 1;
            loadMap(lat,lon,zoom);
        }

        private void button3_Click_1(object sender, EventArgs e)
        {
            if (zoom > 0) zoom = zoom - 1;
            loadMap(lat, lon, zoom);
        }

        private void mapToolStripMenuItem_Click(object sender, EventArgs e)
        {
            MapWindow mapWindow = new MapWindow();
            mapWindow.Show();
        }

        private void button4_Click(object sender, EventArgs e)
        {

           // String text = textBox2.Text;
           // webBrowser2.Navigate("http://api.openweathermap.org/data/2.5/weather?q="+text +"&mode=html&appid=9625d5a354fb59b48949b112091f6b69");
            
            //webBrowser2.Navigate("http://api.openweathermap.org/data/2.5/weather?lat=24.90&lon=91.8&mode=html&appid=9625d5a354fb59b48949b112091f6b69");
        }

        private void button5_Click(object sender, EventArgs e)
        {
            city_name = comboBox4.Text;
            country_name = comboBox3.Text;

            webBrowser3.Navigate("http://localhost/DoneTest/HourlyTest.php?city=" +city_name+"&country="+country_name);
            
        }

        private void helpToolStripMenuItem_Click(object sender, EventArgs e)
        {
            loadMap(lat,lon,zoom);
        }

        private void tabPage1_Click(object sender, EventArgs e)
        {

        }

       
        /*
         * 
         *  GUI Guide for Sensor Data Representation
         * 
         * 
        private void button1_Click(object sender, EventArgs e)
        {
            
            altimeterInstrumentControl1.SetAlimeterParameters(int paramitre);                  //Range(0-10000)Feet
            headingIndicatorInstrumentControl1.SetHeadingIndicatorParameters(int paramitre);   //Range(0-360)degree
            airSpeedInstrumentControl1.SetAirSpeedIndicatorParameters(55);                     //Range(0-800)KNots
            verticalSpeedInstrumentControl1.SetVerticalSpeedIndicatorParameters(100);          //Range(-6000,6000)
            turnCoordinatorInstrumentControl1.SetTurnCoordinatorParameters(Roll_View<-90,90>,);
            horizonInstrumentControl1.SetAttitudeIndicatorParameters(patch,Roll);//(-90,90)
           
        }

        private void button2_Click(object sender, EventArgs e)
        {
            altimeterInstrumentControl1.SetAlimeterParameters(0);
            headingIndicatorInstrumentControl1.SetHeadingIndicatorParameters(50);
            airSpeedInstrumentControl1.SetAirSpeedIndicatorParameters(0);
            verticalSpeedInstrumentControl1.SetVerticalSpeedIndicatorParameters(0);
            turnCoordinatorInstrumentControl1.SetTurnCoordinatorParameters(0, 0);
            horizonInstrumentControl1.SetAttitudeIndicatorParameters(0,0);
        }
         * 
         * 
         * 
         */


    }
}