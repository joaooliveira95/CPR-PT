#!/Python34/python

#import pymysql.cursors
#from pygooglechart import *
#from string import *
#pip install mysqlclient


import cgi
import sys
import json
import serial
import os
import random
import MySQLdb
import time

total = len(sys.argv)
cmdargs = str(sys.argv)

#print ("The total numbers of args passed to the script: %d " % total)
#print ("Args list: %s " % cmdargs)

data=cgi.FieldStorage()

treino=sys.argv[1]
simular=sys.argv[2]

#print ("ID Sessao: %s" % sessao)
#print ("ID Treino: %s" % treino)
#print ("Simular: %s" % simular)

connection = MySQLdb.connect("127.0.0.1","root","","cpr")
cur = connection.cursor()

#pid = str(os.getpid())
#sqlupdatePID = "update treinos set procid=" + pid + " where idsessao=" + sessao+ " and id=" + treino
#cur.execute(sqlupdatePID)
connection.commit()

sensor = ""



if simular == '1':
    
    i = 0
    #SIMULAR VALORES DO ARDUINO
    duration = random.randint(20000, 30000)

    while (i< duration):

        ts = str(i)
        s1= str(random.randint(1, 5000))
        s2 = str(random.randint(1, 500))
        #sqlarduino = "INSERT into valores (idtreino,idsessao,timestamp,sensor1,sensor2) values (" + treino + "," + sessao + ",1234567,10," + x + ")"
        sqlarduino = "INSERT into exercise_sensor_datas (idExercise,idSensor1, idSensor2, idSensor3,valueSensor1, valueSensor2, valueSensor3, timestep) values (" + treino + ", 1, 2, 3,"+s1+"," + s2 + ", 0, " +ts+ ")"
        #print (sqlarduino)ls
        
        cur.execute(sqlarduino)
        connection.commit()
        i = i + 50
        time.sleep(50.0 / 1000.0);


if simular == '0':


    #LER DIRETAMENTE DO ARDUINO
    port = 'COM4'

    ard = serial.Serial(port,9600,timeout=1)

    mat = []
    i = 0
    lixo = 1;
    while (lixo==1):
        msg = ard.readline()
        sensor = str(msg)
        sensor = sensor[2:-5].split(";")

        if len(sensor) > 1:
            lixo=0

            sql = "INSERT into exercise_sensor_datas (idExercise,idSensor1, idSensor2, idSensor3,valueSensor1, valueSensor2, valueSensor3, timestep) values ("+ treino + "," + sessao + "," +str(sensor[0])+","+str(sensor[1])+","+str(sensor[2])+","+str(sensor[3])+","+str(sensor[4])+","+str(sensor[5])+","+str(sensor[6])+","+str(sensor[7])+")"

            cur.execute(sql)
            connection.commit()

    while (1 < 1500):

                # Serial read section
        msg = ard.readline()
                #print (msg)

        sensor = str(msg)
        sensor = sensor[2:-5].split(";")
        mat.append(sensor)

                #print(sensor)

        sql = "INSERT into exercise_sensors_datas (idExercise,idSensor1, idSensor2, idSensor3,timestamp,sensor1,sensor2,sensor3,sensor4,sensor5,sensor6,sensor7) values ("+ treino + "," + sessao + "," +str(sensor[0])+","+str(sensor[1])+","+str(sensor[2])+","+str(sensor[3])+","+str(sensor[4])+","+str(sensor[5])+","+str(sensor[6])+","+str(sensor[7])+")"
                #print(sql)
        cur.execute(sql)
        connection.commit()

        i = i + 1
    else:
        print ("Exiting")

connection.close()
