# CrimeLady-Philly
An Alexa App & API, updating users of local district news such as, missing persons, shootings, assaults, etc.

## Custom Slot Types

   #### *commandNames*
  
   tell me | read me | fetch me | who got | how many

   #### *crimeTypes*

   robbery | assault | missing person | sexual assault | theft | burglary | shooting | homicide | drugs

   #### *districtNames*

   1 | 2 | 3 | 5 | 6 | 7 | 8 | 9 | 12 | 14 | 15 | 16 | 17 | 18 | 19 | 22 | 24 | 25 | 26 | 35 | 39


  #### *navy_names*

  continue | repeat

  #### *NewsNames*

  latest | all | crime | district

  #### *shortTime*

  latest

 #### *timeName*

  yesterday | today | week | weeks | months | month | year | years | days

 #### *yesNo*
 
  yes | no


## Sample Utterances

  Crime lady {answer}
  
  Crime lady {command} the {newsType} news for the {districtNums} district
  
  Crime lady {navigation}
  
  Crime lady {command} the {newsType} news
  
  Crime lady how many {crimeType} happen in the {district} district {presentTime}
  
  Crime lady how many {crimeType} happen {presentTime}
  
  Crime lady how many {crimeType} happened {presentTime} ago
  
  Crime lady where there any {crimeType} in the {district} district {presentTime}
  
  Crime lady where there any {crimeType} {presentTime}
  
  Crime lady where there any {crimeType} {timePeriod} {presentTime} ago
  
  Crime lady where there any {crimeType} this {presentTime}
  
  Crime lady how many {crimeType} happened in the {district} district {timePeriod} {presentTime} ago
