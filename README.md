# baszar
Cash register software for a commission bazaar. 

This software was already used for the last two children's bazaars in our kindergarten. The old solution was a spreadsheet solution. After an Office update, the old software no longer worked and the licenses for the spreadsheet had expired. 
And since more than one cash register was to be used, a new solution had to be found. 

We installed the POS system on a Raspberry. The Raspberry acts as an access point. The cash register laptops only need a Wifi adapter and a browser.  
For data protection reasons there are only seller numbers. The number has to be defined when creating a new bazaar. The seller with the number 50 has a special role. He is billed differently. (see /classes/class_Display_evaluation.php) 

The POS computers log in via browser and the accounting is also carried out via browser at the end. 

The POS system can do the following: 
- Supports multiple tills simultaneously (depending on Raspberry server). 2 cash registers were easily possible with a Raspberry I.)  
- Different evaluations: 
   - Cancellation for the sellers
   - cash statistics
   - document statistics
   - Administration many bazaars, in order to be able to compare these well. 
   - Multilingual support
   
Dependencies:
- jQuery ( /assets/jquery.js)
- Medoo - I use a fork of the medoo project: https://medoo.in/ (/classes/class_Medoo.php)
- Database: sqlLite database (/database/ )

My solution worked with a Wifi. You have to find out with which Wifi stick you can set up an access point. But this is not a part of this project here on GitHub. 



Translated with www.DeepL.com/Translator

---
Kassensoftware für einen Kommissionsbasar. 

Diese Software wurde bereits für die letzten zwei Basare für Kindersachen unseres Kindergartens eingesetzt. Die alte Lösung war eine Tabellenkalkulationslösung. Nach einem Office-Update funktionierte die alte Software nicht mehr und die Lizenzen für die Tabellenkalkulation waren abgelaufen. 
Und da mehr als eine Kasse zum Einsatz kommen sollte, musste eine neue Lösung her. 

Das "Kassensystem" haben wir auf einem Raspberry installiert. Der Raspberry fungiert als Accesspoint. Die Kassenlaptops brauchen also nur ein Wifi-Adapter und einen Browser.  
Aus Datenschutzgründen gibt es nur Verkäufernummern. Die Anzahl muss beim Anlegen eines neuen Basars festgelegt werden. Der Verkäufer mit der Nummer 50 hat eine Sonderrolle. Er wird anders abgerechnet. (siehe /classes/class_Display_evaluation.php) 

Die Kassen-Computer loggen sich via Browser ein und die Abrechnung wird auch via Browser am Ende ausgeführt. 

Das Kassensystem kann folgendes: 
- Unterstützt mehrere Kassen gleichzeitig (abhängig vom Raspberry-Server. 2 Kassen waren mit einen Raspberry I problemlos möglich.)  
- Unterschiedliche Auswertungen: 
   - Abbrechung für die Verkäufer
   - Kassenstatistik
   - Belegstatistik
   - Verwaltung viele Basare, um diese gut vergleichen zu können. 
   - Mehrsprachigkeitsunterstützung
   
Abhängigkeiten: 
- jQuery ( /assets/jquery.js)
- Medoo - ich verwende einen Fork des medoo-Projektes: https://medoo.in/  (/classes/class_Medoo.php)
- Datenbank: sqlLite-Datenbank (/database/ )

Meine Lösung funktionierte mit einem Wifi. Da muss man sich schlau machen, mit welchem Wifi-Stick man ein Accesspoint einrichten kann. Das ist aber kein Teil dieses Projektes hier auf GitHub. 

