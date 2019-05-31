![](https://raw.githubusercontent.com/nfqakademija/workchase/master/public/img/logo.png)

## Projekto aprašymas

Pastebėjome, kad dažnai taip nutinka, kad reiktų, kad kas nors atliktų 
kokį nors darbą darbą (pavyzdžiui, nupjautų žolę, perdažytų sienas ir pan.) tačiau nežinome, 
kas galėtų tai atlikti arba kokio specialisto mums reikia. Galima praleisti ilgas valandas internete ieškant 
kandidato, tačiau pasirinktas žmogus nebūtinai bus tinkamas. 

Sukūrėme platformą [Workchase](http://workchase.projektai.nfqakademija.lt),
kurioje užsakovas - žmogus, kuris turi darbo pasiūlymą - galėtų patalpinti savo skelbimą ir visi norintys bei gebantys
jį atlikti atsilieptų ir pasiūlytų savo kandidatūrą. Užsakovas gali peržiūrėti pasisisiūliusius kandidatus, 
pasirinkri labiausiai tinkantį ir jį pasamdyti. Atlikus darbą, užsakovas gali įvertinti jį atlikusį asmenį
ir tokiu būdų jį parekomenduoti kitiems. 

Kviečiame prisijungti prie [Workchase](http://workchase.projektai.nfqakademija.lt) platformos ir jau šiandien susirasti asmenį, kuris jums padėtų!



#### Projekto komanda

- Mentorius Laurynas
- Aurimas
- Martyna
- Vilius


### Reikalavimai
* docker: `18.x-ce`
* docker-compose: `1.23.2`


### Projekto paleidimas

Pasileidžiant pirmą kartą būdavo įveliama daug klaidų, todėl padaryti _script'ai_ dažniausiems atvejams.

* Pasileidžiama infrastruktūrą per `docker`į:
```bash
scripts/start.sh
```

* Įsidiegiame PHP ir JavaScript bibliotekas:
```bash
scripts/install-first.sh
```

* Pasižiūrime, ar veikia.
  Naršyklėje atidarius [`http://127.0.0.1:8000/`](http://127.0.0.1:8000/) turėtų rašyti `NFQ Akademija`

* Pabaigus, gražiai išjungiame:
```bash
scripts/stop.sh
```

### Patogiai darbo aplinkai

* _Development_ režimas (detalesnė informacija apie klaidas, automatiškai generuojami JavaScript/CSS):
```bash
scripts/install-dev.sh
```

* _Production_ režimas (imituoti, kaip daroma LIVE serveryje. Plačiau [.deploy/build.sh](.deploy/build.sh)):
```bash
scripts/install-prod.sh
```

* Jei norite pridėti PHP biblioteką arba dirbti su Symfony karkasu per komandinę eilutę:
```bash
scripts/backend.sh
```

* Jei norite pridėti JavaScript/CSS biblioteką arba dirbti su Symfony Encore komponentu per komandine eilutę:
```bash
scripts/frontend.sh
```

* Jei norite dirbti su MySql duomenų baze:
```bash
scripts/mysql.sh
```

* Jei nesuprantate, kas vyksta su infrastruktūra, praverčia pažiūrėti į `Log`'us:
```bash
scripts/logs.sh
```

* Jei kažką stipriai sugadinote ir niekaip nepavyksta atstatyti.
  Viską pravalyti (**naudokite atsakingai**) galima su:
```bash
scripts/clean-and-start-fresh.sh
```

### Dažniausiai užduodami klausimai

* **Kaip įkelti savo pakeitimus į LIVE?**
Jei viskas gerai sukonfiguruota, užteks sudėti pakeitimus į `master`.
Jei neveiks, plačiau žr. [įkėlimo į serverį dokumentacijoje](https://github.com/nfqakademija/docker/blob/master/docs/deploy-project.md)

* **Kaip prisijungti prie duomenų bazės su savo mėgstamu MySql redagtoriumi?**
Trumpai: `scripts/mysql.sh` atspausdina visus prisijungimus.
Plačiau žr. [MySql GUI dokumentacijoje](https://github.com/nfqakademija/docker/blob/master/docs/use-mysql-with-gui.md)

* **Kaip pasileisti xDebug?**
Trumpai: `./scripts/backend.sh /enable_xdebug.sh <TAVO_KOMPO_IP_ADRESAS>`
Plačiau žr. [xDebug dokumentacijoje](https://github.com/nfqakademija/docker/blob/master/docs/setup-xdebug.md)

* **Turių daugiau techninių klausimų?**
Google ir StackOverflow yra geriausi tavo draugai.
Nepavykus – kreipkis į savo mentorių. Jei jis nepadės,
nukreips į atitinkamą lektorių arba pamokys `git blame`,
kad žinotumei, kur kreiptis toliau. 

### Feedbackas

Jeigu taip nutiktų, kad repositorijoje, projekto template ar instrukcijoje rastumėte klaidą, tai nesišnibždėkite vieni tarp kitų, o sukurkite "issue". 
O jei atidarysite "pull requestą" su fixu, gausite iškart 1000 karmos taškų.
