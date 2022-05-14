##Ce que j vais utiliser ?

	https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=myriam

	php

	JavaScript

	sql

##Quelques infos utiles:

	https://goqr.me/api/doc/create-qr-code/

##Comment je vais l'utiliser ?

	Je creerai ma base de données un petit formulaire pour inserer son nom son prenom et une date puis je l'appelerais avec PDO ou je lui
	dirais de faire une sorte de concatenation : 

	https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=":nom".+.":prenom".+.":dateajd".+.":datefin" 

	un truc genre comme ça il faudra aussi verifier si la personne et bien connu de la base de données car je suppose que les personnes 	 autoriser seront restreintes

	il faudra aussi un input hidden peut être pour la date à laquelle l'application sera créer 
	
	Tu peux potentiellemnt t'aider de tes ancien devoir 

##Ce qu'il ne faut pas faire :

	Ne pas laisser de commentaire il est imperatif qu'il y ai des commentaires dans mon code.
