# Stuff service
-------

The stuf service aims to provide a broad interface for sending api request out of the commonground ecosystem. 
Do originally designed to serve the dutch stuf standard the interface by its nature can turn linkd-data json requests into single sets xml request. It can there be implemented into an (SOAP) xml service (including for example electronic billing).

## Authenticating against your stuf endpoint

If the receiver of the message requires a username/password authentication, the entity contains properties for them, of which the password property will not be shown when requesting the entity. These parameters will be passed on as basic auth, except when also the 'digest' property is set, then the component will pass it on as digest authentication.

## Turning a (LD-)JSON request to XML

In order 

The chaining of call's is not yet supported (making several calls in order to render a single responce). It's definitly on our want list but we havn't yet found a donor willing to provide it. Sorry. 

## Turning XML to JSON

The component provides three basic routes for receiving information back from an (soap) xml endpoint. 
1.	Plain transformation (default): The XML data is serialized according to the provided `Accept` header. If no `Accept`  header is provided it is serialized to plain json if the provided  `Accept` header is `application/xml` the data is not serialized.
2.	By mapping: 
3.	By templating:

When using a stuff call that could return several commonground objects we recomond using a ld-json resonce (wich also happens to be the commongground default). It both supports the possiblity of returening sever objects of differend type in de _embeded property and profides the nifty @type property to keep them appart.  

## Adding your own message templates

You can add your own message templates to this service, since the service a susch is a community effort the preffered way of doing so would be to [create a branch]() and your templates and the start a pull request to provide your templates to others.


### Folder structure 

Templates should be stored under the 

### Using data from commonground sources

The challange with the linked data concept of commonground is that alle the data that you need for a single message stuff call (wich historicallly need a complete dataset) is divided agains multiple api's. To preffent applications doing broad fatches before an call to the stuff component, the component itszelf provides an enrichment service as a twig template function. his helps developers.

How does that work?
In a commonground or other linked data concept a object will regularu contain a link (or full url) to a differend object. for example we might have two resources tat live on defernd api's.

```json
{
	....
	'name':"Resource1",
	'desciption':"This is my first resource",
	'myMate':"https://some-component.domain.com/api/v1/5a922f48-e0c8-48e8-937a-e390867cc847",
},
{
	....
	'name':"Resource2",
	'desciption':"This is my secone resource",
}
```

We can then build the following twig (xml in this case template) and provide it with { data: resourece1}

```xml
.....
<resoruces>
	<resource name="{{ data.name }}">
		<description>{{ data.description }}></description>
		<mate name="{{ commonground_resource(data.mate).name }}">
			<description>{{ commonground_resource(data.mate).description }}></description>
		</mate>
	</resource>
</resoruces>
```

This way the stuff component only needs your starting point (resource) and can grap al the other resources that are needed to make a full stuf message on its own. Therby dramaticcly speeding up the development prossec

The enrichmentservices uses cashing to prefent "double" calls if the same resource is collected more then once.


### Template abstractions

Stuff mesagges tend to get enormos, with fast amounts of repeated resources and in the case of xml nodes. To prevent code dublication, improve project maintanance and make everything more readable we recomond using twig abstration. Or to put it more simple re use parts of your template by spiltiing of into small resuable block and in including them. This also works very wel with the option of loops. Let rewrite te above example in a slightly more abstract way. 

```xml
.....
<resoruces>
	<resource name="{{ data.name }}">
		<description>{{ data.description }}></description>
        {% for user in users %}
        {% include '/request/example/resources/resource.html' with {'resource': commonground_resource(data.mate)} %}
        {% endfor %}
	</resource>
</resoruces>
```

### Authenticating agains commonground sources

In order for the stuf component to collect additional commonground data it needs acces to that data, from a security perspective the preffered way of doing this authorising the stuf component. This would also have the beniffit of cousing propper logging. 

You can however for practical reasons also opt for 'on behalve of authentication', in which case you provide the component with references for the specific endpoints that it needs on an domain basis (the assumption here being that one might need different authentications for different components and that components are hosted on domains). 

Authentications should be an array of authentication  objects.

```json
{
	....
	'authentication':[
		{
			// the stuff component wil use {url}* to determine if this authentication should be used for a component
			'url':'string',
			// the value for the atunehticion header
			'authentication':'',
			// if authentication is not provided, information for the creation of a json web token to be set as authentication header
			'client_id':'string',
			'secret':string',
		},
		{
			'url':'string',
			'authentication':'',
			'client_id':'string',
			'secret':string',
		}
	]
}
```

If authentication has not been provided for an component the StUF component wil use its own authentication (as provided in the .env file).

## License

Copyright &copy; [Gemeente Utrecht](https://www.utrecht.nl/)  2020 

Licensed under [EUPL](https://github.com/ConductionNL/trouwencomponent/blob/master/LICENSE.md)

## Credits

[![Utrecht](https://raw.githubusercontent.com/ConductionNL/trouwencomponent/master/resources/logo-utrecht.svg?sanitize=true "Utrecht")](https://www.utrecht.nl/)
[![Conduction](https://raw.githubusercontent.com/ConductionNL/trouwencomponent/master/resources/logo-conduction.svg?sanitize=true "Conduction")](https://www.conduction.nl/)
