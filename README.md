# Readme
-------

The stuf service aims to provide a broad interface for sending api request out of the commonground ecosystem. 
Do originally designed to serve the Dutch stuf standard the interface by its nature can turn linked-data json requests into single sets xml request. It can there be implemented into an (SOAP) xml service (including for example electronic billing).

## Authenticating against your stuf endpoint

If the receiver of the message requires a username/password authentication, the entity contains properties for them, of which the password property will not be shown when requesting the entity. These parameters will be passed on as basic auth, except when also the 'digest' property is set, then the component will pass it on as digest authentication.

## Sending a request

* Build in support for public API's like BAG (Kadaster), KVK (Kamer van Koophandel)
* Build in validators for common dutch variables like BSN (Burger service nummer), RSIN(), KVK(), BTW()
* AVG and VNG proof audit trails
* And [much more](https://packagist.org/packages/conduction/commongroundbundle) .... 

In order to create and send an stuf request a REST JSON call should be made to the stuf interface endpoint. This call should at the lease contain 
- The data that should be posted (that should preferably be as litle as an url to the commonground resource at the hard of the request).
- The template used
- Information on the stuf endpoint

The stuf component wil the use the given template and data as a staroff point enriching both data and temple to render a message. The message wil then be posted (within an option soap envelope) to the stuff endpoint.  

The chaining of call's is not yet supported (making several calls in order to render a single response). It's definitely on our want list but we haven’t yet found a donor willing to provide it. Sorry. 

## Recieving a responce

The component provides three basic routes for receiving information back from an (soap) xml endpoint. 
1.	Plain transformation (default): The XML data is serialized according to the provided `Accept` header. If no `Accept`  header is provided it is serialized to plain json if the provided  `Accept` header is `application/xml` the data is not serialized.
2.	By mapping: `Not yet supported`
3.	By templating: 

When using a stuff call that could return several commonground objects we recommend using a ld-json response (wich also happens to be the commongground default). It both supports the possibility of returning sever objects of different type in de _embeded property and provides the nifty @type property to keep them apart.  

## Adding your own message templates

You can add your own message templates to this service, since the service a susch is a community effort the preffered way of doing so would be to [create a branch]() and your templates and the start a pull request to provide your templates to others.

### Folder structure 

Templates should be stored under the [api/templastes](/api/templates) folder in respactivly the [request](/api/template/request) or [responce](/api/template/responce) folder. Then in the GEMMA spefic folder (e.g. rgbz) and should be named after there GEMMA object or resource

### Using data from commonground sources

The challenge with the linked data concept of commonground is that alle the data that you need for a single message stuff call (which historically need a complete dataset) is divided against multiple api's. To prevent applications doing broad fetches before an call to the stuff component, the component itself provides an enrichment service as a twig template function. his helps developers.

How does that work?
In a commonground or other linked data concept an object will regular contain a link (or full url) to a different object. for example we might have two resources tat live on diferend api's.

```json
{
	"name":"Resource1",
	"description":"This is my first resource",
	"myMate":"https://some-component.domain.com/api/v1/5a922f48-e0c8-48e8-937a-e390867cc847",
},
{
	"name":"Resource2",
	"description":"This is my secone resource",
}
```

We can then build the following twig (xml in this case template) and provide it with { data: resourece1}

```xml
<resoruces>
	<resource name="{{ data.name }}">
		<description>{{ data. description }}></description>
		<mate name="{{ commonground_resource(data.mate).name }}">
			<description>{{ commonground_resource(data.mate).description }}></description>
		</mate>
	</resource>
</resoruces>
```

This way the stuff component only needs your starting point (resource) and can grap al the other resources that are needed to make a full stuf message on its own. Thereby dramatically speeding up the development proses

The enrichment services uses cashing to prevent "double" calls if the same resource is collected more then once.


### Template abstractions

Stuff mesagges tend to get enormos, with fast amounts of repeated resources and in the case of xml nodes. To prevent code dublication, improve project maintanance and make everything more readable we recomond using twig abstration. Or to put it more simple re use parts of your template by spiltiing of into small resuable block and in including them. This also works very wel with the option of loops. Let rewrite te above example in a slightly more abstract way. 

```xml
<resoruces>
	<resource name="{{ data.name }}">
		<description>{{ data. description }}></description>
        {% for user in users %}
        {% include '/request/example/resources/resource.html' with {'resource': commonground_resource(data.mate)} %}
        {% endfor %}
	</resource>
</resoruces>
```

## Authenticating against commonground sources

In order for the stuf component to collect additional commonground data it needs access to that data, from a security perspective the preferred way of doing this authorizing the stuf component. This would also have the benefit of causing proper logging. 

You can however for practical reasons also opt for 'on behalf of' authentication, in which case you provide the component with references for the specific endpoints that it needs on an domain basis (the assumption here being that one might need different authentications for different components and that components are hosted on domains). 

Authentications should be an array of authentication  objects. The stuff component will use {url}* to determine if this authentication should be used for a component and use the authentication value for the authentication header or if authentication is not provided wil use client_id and secret information for the creation of a json web token to be set as authentication header

```json
{
	"authentication":[
		{
			"url":"string",
			"authentication":"string",
			"client_id":"string",
			"secret":"string",
		},
		{
			"url":"string",
			"authentication":"string",
			"client_id":"string",
			"secret":"string",
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
