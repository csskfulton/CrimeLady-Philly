# CrimeLady-Philly
An Alexa App & API, updating users of local district news such as, missing persons, shootings, assaults, etc.

## Intent Schema
```
{
  "intents": [
    {
      "slots": [
        {
          "name": "answer",
          "type": "yesNo"
        }
      ],
      "intent": "ackResponse"
    },
    {
      "intent": "AMAZON.CancelIntent"
    },
    {
      "intent": "AMAZON.HelpIntent"
    },
    {
      "intent": "AMAZON.StopIntent"
    },
    {
      "slots": [
        {
          "name": "districtNums",
          "type": "districtNames"
        },
        {
          "name": "newsType",
          "type": "NewsNames"
        },
        {
          "name": "navigation",
          "type": "navy_names"
        },
        {
          "name": "command",
          "type": "commandNames"
        }
      ],
      "intent": "districtNews"
    },
    {
      "slots": [
        {
          "name": "presentTime",
          "type": "timeName"
        },
        {
          "name": "countVal",
          "type": "AMAZON.NUMBER"
        },
        {
          "name": "district",
          "type": "districtNames"
        },
        {
          "name": "crimeType",
          "type": "crimeTypes"
        },
        {
          "name": "timePeriod",
          "type": "AMAZON.NUMBER"
        }
      ],
      "intent": "fetchStats"
    }
  ]
}
```
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

  ackResponse {answer}
  
  districtNews {command} the {newsType} news for the {districtNums} district
  
  districtNews {navigation}
  
  districtNews {command} the {newsType} news
  
  fetchStats how many {crimeType} happen in the {district} district {presentTime}
  
  fetchStats how many {crimeType} happen {presentTime}
  
  fetchStats how many {crimeType} happened {presentTime} ago
  
  fetchStats where there any {crimeType} in the {district} district {presentTime}
  
  fetchStats where there any {crimeType} {presentTime}
  
  fetchStats where there any {crimeType} {timePeriod} {presentTime} ago
  
  fetchStats where there any {crimeType} this {presentTime}
  
  fetchStats how many {crimeType} happened in the {district} district {timePeriod} {presentTime} ago
