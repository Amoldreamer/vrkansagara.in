<?php

use PhlyBlog\AuthorEntity;
use PhlyBlog\EntryEntity;

$entry  = new EntryEntity();
$author = new AuthorEntity();
$author->fromArray([
    'id'    => 'vrkansagara',
    'name'  => 'Vallabh Kansagara',
    'email' => 'vrkansagara@gmail.com',
    'url'   => 'https://vrkansagara.in',
]);

$entry->setId(pathinfo(__FILE__, PATHINFO_FILENAME));
$entry->setTitle('Zend framework quick guide');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2019:09:01 16:33:48'));
$entry->setUpdated(new DateTime('2019:09:01 16:35:03'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['php','framework','zend']);

$body = <<<'EOT'
Quick overview on Zend Framework 3 with enough details.
* Zend\EventManager component allows to send events and register listeners to react to them.

* Zend\ModuleManager. In ZF3, every application consists of modules and this component contains module loading functionality.

* Zend\ServiceManager. This is the centralized registry of all services available in the application, making it possible to access services from any point of the web site.

EOT;
$entry->setBody(convertMarkdownToHtml($body));
$extended = <<<'EOT'
* Zend\Http provides an easy interface for performing Hyper-Text Transfer Protocol (HTTP) requests.

* Zend\Mvc. Support of Model-View-Controller pattern and separation of business logic from presentation.

* Zend\View. Provides a system of helpers, output filters, and variable escaping. Used in presentation layer.

* Zend\Form. Web form data collection, filtering, validation and rendering.

* Zend\InputFilter. Provides an ability to define form data validation rules.

* Zend\Filter. Provides a set of commonly used data filters, like string trimmer.

* Zend\Validator. Provides a set of commonly used validators.


###  Events & Application's Life Cycle

Each application life stage is initiated by the application by triggering an event (this event is represented by the MvcEvent class living in Zend\Mvc namespace). Other classes (either belonging to Zend Framework or specific to your application) may listen to events and react accordingly.

Below, the five main events (life stages) are presented:

Bootstrap. When this event is triggered by the application, a module has a chance to register itself as a listener of further application events in its onBootstrap() callback method.

Route. When this event is triggered, the request's URL is analyzed using a router class (typically, with Zend\Router\Http\TreeRouteStack class). If an exact match between the URL and a route is found, the request is passed to the site-specific controller class assigned to the route.

Dispatch. The controller class "dispatches" the request using the corresponding action method and produces the data that can be displayed on the web page.

Render. On this event, the data produced by the controller's action method are passed for rendering to Zend\View\Renderer\PhpRenderer class. The renderer class uses a view template file for producing an HTML page.

Finish. On this event, the HTTP response is sent back to client.

![Life cycle](https://vrkansagara.in/storage/app/media/zf3/zf3_app_life_cycle.png)


---

# Common Services Name and it's short description
---

# `Application`

Allows to retrieve the singleton of `[Zend\Mvc\Application]` class.

`ApplicationConfig`

Configuration array extracted from _application.config.php_ file.

# `Config`

Merged configuration array extracted from _module.config.php_ files merged with _autoload/global.php_ and _autoload/local.php_.

`EventManager`

Allows to retrieve a _new_ instance of `[Zend\EventManager\EventManager]` class. The event manager allows to send (trigger) events and attach event listeners.

# `SharedEventManager`

Allows to retrieve the singleton instance of `[Zend\EventManager\SharedEventManager]` class. The shared event manager allows to listen to events defined by other classes and components.

# `ModuleManager`

Allows to retrieve the singleton of `[Zend\ModuleManager\ModuleManager]` class. The module manager is responsible for loading application modules.

# `Request`

The singleton of `[Zend\Http\Request]` class. Represents HTTP request received from client.

# `Response`

The singleton of `[Zend\Http\Response]` class. Represents HTTP response that will be sent to client.

# `Router`

The singleton of `[Zend\Router\Http\TreeRouteStack]`. Performs URL routing.

# `ServiceManager`

Service manager itself.

# `ViewManager`

The singleton of `[Zend\Mvc\View\Http\ViewManager]` class. Responsible for preparing the view layer for page rendering.


---

# Event & MvcEvent

---


An event is technically an instance of the Zend\EventManager\Event class. An event can basically have at least the following parts:

###### name - uniquely identifies the event
###### target - this is typically a pointer to the object which triggered the event
###### params - event-specific arguments passed to the event listeners.


It is possible to create custom types of events by extending the Event class. For example, the Zend\Mvc component defines the custom event type named Zend\Mvc\MvcEvent, which extends the Event class and adds several properties and methods needed for the Zend\Mvc component to work.


---
#EventManager & SharedEventManager
---
It is important to understand the difference between the usual event manager and the shared event manager.

The usual event manager is not stored as a singleton in the service manager. Every time you request the EventManager service from the service manager, you receive a new instance of it. This is done for privacy and performance reasons:

- It is assumed by default that the class triggering events will request and save somewhere its own private event manager, because it doesn't want other classes to automatically listen to those events. Events triggered by the class are assumed to belong to that class privately.

- If anyone would be able to listen to any event triggered by any class, there would be performance hell - too many event listeners would be invoked, thus increasing page load time. It is better to avoid this by keeping events private.

But, in case if someone intentionally needs to listen to other's events, there is a special shared event manager. The SharedEventManager service is stored in the service manager as a singleton, so you can be sure everyone will have the same instance of it.

With the SharedEventManager, you can attach a listener to private events triggered by certain class (or several classes). You specify the unique class identifier(s) to which you would like to listen. That simple!


---
# Model-View-Controller
--- 


- Zend\Mvc	- Support of MVC pattern. Implements base controller classes, controller plugins, etc.
- Zend\View	- Implements the functionality for variable containers, rendering a web page and common view helpers.
- Zend\Http	- Implements a wrapper around HTTP request and response.


*Method Name*                    | *Description*
|----------------------------------|--------------------------------------------------------|
| `getRequest()`                   | Retrieves the @`Zend\Http\Request` object, which is the |
|                                  | representation of HTTP request data.                   |
| `getResponse()`                  | Retrieves the @`Zend\Http\PhpEnvironment\Response` object|
|                                  | allowing to set data of HTTP response.                 |
| `getEventManager()`              | Returns the @`Zend\EventManager\EventManager` object,   |
|                                  | allowing to trigger events and listen to events.       |
| `getEvent()`                     | Returns the @`Zend\Mvc\MvcEvent` object, which represents|
|                                  | the event the controller responds to.                  |
| `getPluginManager()`             | Returns the @`Zend\Mvc\Controller\PluginManager` object,|
|                                  | which can be used for registering controller plugins.  |
| `plugin($name, $options)`        | This method allows to access certain controller plugin |
|                                  | with the given name.                                   |
| `__call($method, $params)`       | Allows to call a plugin indirectly using the PHP `__call` |
|                                  | magic method.                                          |
--- 
#  Retrieving Data from HTTP Request `$this->request()`
---


| *Method Name*                          | *Description*                                        |
|----------------------------------------|------------------------------------------------------|
| `isGet()`                              | Checks if this is a GET request.                     |
| `isPost()`                             | Checks if this is a POST request.                    |
| `isXmlHttpRequest()`                   | Checks if this request is an AJAX request.           |
| `isFlashRequest()`                     | Check if this request is a Flash request.            |
| `getMethod()`                          | Returns the method for this request.                 |
| `getUriString()`                       | Returns the URI for this request object as a string. |
| `getQuery($name, $default)`            | Returns the query parameter by name, or all query parameters. |
|                                        | If a parameter is not found, returns the `$default` value.|
| `getPost($name, $default)`             | Returns the parameter container responsible for post |
|                                        | parameters or a single post parameter.               |
| `getCookie()`                          | Returns the Cookie header.                           |
| `getFiles($name, $default)`            | Returns the parameter container responsible for file |
|                                        | parameters or a single file.                         |
| `getHeaders($name, $default)`          | Returns the header container responsible for headers |
|                                        | or all headers of a certain name/type.               |
| `getHeader($name, $default)`           | Returns a header by `$name`. If a header is not found,   |
|                                        | returns the `$default` value.                        |
| `renderRequestLine()`                  | Returns the formatted request line (first line) for  |
|                                        | this HTTP request.                                   |
| `fromString($string)`                  | A static method that produces a Request object from a|
|                                        | well-formed Http Request string                      |
| `toString()`                           | Returns the raw HTTP request as a string.            |

--- 
## Retrieving GET and POST Variables
--- 

To simply get a GET or POST variable from an HTTP request, you use the following code:

~~~php
// Get a variable from GET
$getVar = $this->params()->fromQuery('var_name', 'default_val');

// Get a variable from POST
$postVar = $this->params()->fromPost('var_name', 'default_val');
~~~

--- 
# Putting Data to HTTP Response  `$this->response()`
--- 
Although you rarely interact with HTTP response data directly, you can do that
with the help of `getResponse()` method provided by the @`AbstractActionController`[Zend\Mvc\Controller\AbstractActionController] base class.
The `getResponse()` method returns the instance of @`Zend\Http\PhpEnvironment\Response` class.

| *Method Name*                          | *Description*                                          |
|----------------------------------------|--------------------------------------------------------|
| `fromString($string)`                  | Populate response object from string.                  |
| `toString()`                           | Renders entire response as HTTP response string.       |
| `setStatusCode($code)`                 | Sets HTTP status code and (optionally) message.        | 
| `getStatusCode()`                      | Retrieves HTTP status code.                            | 
| `setReasonPhrase($reasonPhrase)`       | Sets the HTTP status message.                          | 
| `getReasonPhrase()`                    | Gets HTTP status message.                              |
| `isForbidden()`                        | Checks if the response code is 403 Forbidden.          |
| `isNotFound()`                         | Checks if the status code indicates the resource is not found (404 status code). |
| `isOk()`                               | Checks whether the response is successful.             |
| `isServerError()`                      | Checks if the response is 5xx status code.             | 
| `isRedirect()`                         | Checks whether the response is 303 Redirect.           | 
| `isSuccess()`                          | Checks whether the response is 200 Successful.         |
| `setHeaders(Headers $headers)`         | Allows to set response headers.                        |
| `getHeaders()`                         | Returns the list of response headers.                  |
| `getCookie()`                          | Retrieves Cookie header.                               |
| `setContent($value)`                   | Sets raw response content.                             |
| `getContent()`                         | Returns raw response content.                          |
| `getBody()`                            | Gets and decodes the content of the response.          |

For example, use the following code to set 404 status code for the response:

~~~php
$this->getResponse()->setStatusCode(404);
~~~

Use the following code to add a header to response:

~~~php
$headers = $this->getResponse()->getHeaders();
$headers->addHeaderLine(
    "Content-type: application/octet-stream");
~~~

Use the following code to set response content:

~~~php
$this->getResponse()->setContent('Some content');
~~~

--- 
# Variable Containers ` $view = new ViewModel()`
--- 

The @`ViewModel`[Zend\View\Model\ViewModel] class provides several methods that you can additionally use to 
set variables to @`ViewModel`[Zend\View\Model\ViewModel] and retrieve variables from it.



| *Method name*                  | *Description*                                                 |
|--------------------------------|---------------------------------------------------------------|
| `getVariable($name, $default)` | Returns a variable by name (or default value if the variable does not exist).|
| `setVariable($name, $value)`   | Sets a variable.                                              |
| `setVariables($variables, $overwrite)`|  Sets a group of variables, optionally overwriting the existing ones.|
| `getVariables()`               | Returns all variables as an array.                            |
| `clearVariables()`             | Removes all variables.                                        |



--- 
# Controller Plugins
---

#### A controller plugin is a class which extends the functionality of all controllers in some way.


| *Standard Plugin Class*                  | *Description*                                        |
|------------------------------------------|------------------------------------------------------|
| @`Params`                                 | Allows to retrieve variables from HTTP request,      |
|                                          | including GET and POST variables.                    |
| @`Url`[Zend\Mvc\Controller\Plugin\Url]                                    | Allows to generate absolute or relative URLs         |
|                                          | from inside controllers.                             |
| @`Layout`[Zend\Mvc\Controller\Plugin\Layout]                                 | Gives access to layout view model for passing data to|
|                                          | layout template.                                     |
| @`Identity`[Zend\Mvc\Plugin\Identity\Identity]                               | Returns the identity of the user who has logged into the |
|                                          | website.                                            |
| @`FlashMessenger`[Zend\Mvc\Plugin\FlashMessenger\FlashMessenger]                         | Allows to define "flash" messages which are stored in|
|                                          | session and can be displayed on a different web page.|
| @`Redirect`[Zend\Mvc\Controller\Plugin\Redirect]                               | Allows to redirect the request to another controller's |
|                                          | action method.                                       |
| @`PostRedirectGet`[Zend\Mvc\Plugin\Prg\PostRedirectGet]                        | Redirects the POST request, converting all POST variables |
|                                          | to GET ones.                                         |
| @`FilePostRedirectGet`[Zend\Mvc\Plugin\FilePrg\FilePostRedirectGet]                    | Redirects the POST request, preserving uploaded files.|



Inside of the controller's action method, you access a plugin in the following way:

~~~php
// Access Url plugin
$urlPlugin = $this->url();

// Access Layout plugin
$layoutPlugin = $this->layout();

// Access Redirect plugin
$redirectPlugin = $this->redirect();
~~~

As an alternative, you can invoke a plugin by its fully qualified name with the `plugin()` method provided by the base controller
class, as follows:

~~~php
use Zend\Mvc\Controller\Plugin\Url; 
 
// Inside your controller's action use the plugin() method.
$urlPlugin = $this->plugin(Url::class);
~~~


--- 
# Writing Own Controller Plugin
--- 

In your websites, you will likely need to create custom controller plugins.
For example, assume you need that all your controller classes to be able to check
whether a site user is allowed to access certain controller action. This can be 
implemented with the `AccessPlugin` class. 

The controller plugin should be derived from the @`AbstractPlugin`[Zend\Mvc\Controller\Plugin\AbstractPlugin] class.
Plugins typically live in their own namespace `Plugin`, which is nested in 
`Controller` namespace:

~~~php
<?php
namespace Application\Controller\Plugin; 

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

// Plugin class
class AccessPlugin extends AbstractPlugin 
{
    // This method checks whether user is allowed
    // to visit the page 
    public function checkAccess($actionName)
    {
        // ...
    }
}
~~~

To let Zend Framework 3 know about your plugin, you need to register 
it in your *module.config.php* file under the `controller_plugins` key.
See below for example:


~~~php
<?php
return [
    // ... 
 
    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\AccessPlugin::class => InvokableFactory::class,
        ],
        'aliases' => [
            'access' => Controller\Plugin\AccessPlugin::class,
        ]
    ],
 
    // ...
];
~~~

> Please note that we also register an alias for the plugin to be able to get the plugin by its short name.

After that, you'll be able to access your custom plugin from
all of your controller's actions in this way:

~~~php
// Check if site user is allowed to visit the "index" page
$isAllowed = $this->access()->checkAccess('index');
~~~



# View Helpers
A *view helper* is typically a (relatively) simple PHP class whose goal is to render some part of a view.
You can invoke view helpers from any view template. With view helpers, you can create reusable widgets
(like menus, navigation bars, etc.) for your web pages.

>View helpers are analogous to controller plugins: the controller plugins allow to "extend" the functionality of controllers, and view helpers allow to "extend" the functionality of view templates.

ZF3 provides many standard view helpers out of the box.

| *Standard Plugin Class*                  | *Description*                                        |
|------------------------------------------|------------------------------------------------------|
| @`BasePath`                               | Allows to retrieve the base path to the web application, |
|                                          | which is the absolute path to `APP_DIR`.             |
| @`Url`[Zend\View\Helper\Url]                                    | Allows to generate absolute or relative URL addresses|
|                                          | from inside view templates.                          |
| @`ServerUrl`                              | Retrieves the current request's URL.                 |
| @`Doctype`                                | Helper for setting and retrieving the doctype HTML element |
|                                          | of the web page.                                     |
| @`HeadTitle`                              | Helper for setting the title HTML element            |
|                                          | of the web page.                                     |
| @`HtmlList`                               | Helper for generating ordered and unordered HTML lists. |
| @`ViewModel`[Zend\View\Helper\ViewModel]                              | Helper for storing and retrieving the view model     |
| @`Layout`[Zend\View\Helper\Layout]                                 | Retrieves the layout template view.                  |
| @`Partial`                                | Allows to render a "partial" view template.          |
| @`InlineScript`                           | Helper for setting and retrieving script elements for|
|                                          | inclusion in HTML body section.                      |
| @`Identity`[Zend\View\Helper\Identity]                               | View helper to retrieve the authenticated user's identity. |
| @`FlashMessenger`[Zend\View\Helper\FlashMessenger]                         | Allows to retrieve the "flash" messages stored in    |
|                                          | session.                                             |
| @`EscapeHtml`                             | Allows to escape a variable outputted to a web page. |

To demonstrate the usage of a view helper, below we will show how to set a title for a web page.
Typically, it is required to give a different title per each web page. You can do this
with the @`HeadTitle` view helper. For example, you can set the title for the *About*
page by adding the following PHP code in the beginning of the *about.phtml* view template:

~~~php
<?php
$this->headTitle('About');
~~~

In the code above, we call the @`HeadTitle` view helper and pass it the page title string ("About") 
as the argument. The @`HeadTitle` view helper internally sets the text for the `<title>` HTML
element of your web page. Then, if you open the *About* page in your web browser, 
the page title will look like "About - ZF Skeleton Application" (see the figure 4.9
below for an example):


--- 
# Overriding Default View Template Name
---

The @`ViewModel`[Zend\View\Model\ViewModel] can also be used to override the default view template resolving.
Actually the @`ViewModel`[Zend\View\Model\ViewModel] class is more than just a variable container. Additionally, it 
allows to specify which view template should be used for page rendering. The summary
of methods provided for this purpose is shown in table

| *Method name*                  | *Description*                                                 |
|--------------------------------|---------------------------------------------------------------|
| `setTemplate()`                | Sets the view template name.                                  |
| `getTemplate()`                | Returns the view template name.                               |

~~~php
// Index action renders the Home page of your site.
public function indexAction() 
{    
	// Use a different view template for rendering the page.
	$viewModel = new ViewModel();
	$viewModel->setTemplate('application/index/about');
	return $viewModel;
}
~~~


---
# Routing
--- 

When a site user enters a URL in a web browser, the HTTP request is finally dispatched to
controller's action in your ZF3-based website. we will learn about how ZF3-based application maps page URLs to
controllers and their actions. This mapping is accomplished with the help of routing.
Routing is implemented as a part of @`Zend\Router` component.


| *Component*                    | *Description*                                                 |
|--------------------------------|---------------------------------------------------------------|
| @`Zend\Router`                  | Implements support of routing.                                |
| @`Zend\Barcode`                 | Auxiliary component implementing barcodes.                    |

--- 
# Route Types
--- 

| *Route Type*                   | *Description*                                                 |
|--------------------------------|---------------------------------------------------------------|
| *Literal*                      | Exact matching against the path part of a URL.                |
| *Segment*                      | Matching against a path segment (or several segments) of a URL. |
| *Regex*                        | Matching the path part of a URL against a regular expression template.|
| *Hostname*                     | Matching the host name against some criteria.                 |
| *Scheme*                       | Matching URL scheme against some criteria.                    |
| *Method*                       | Matching an HTTP method (e.g. GET, POST, etc.) against some criteria. |


--- 
# View Helper
--- 


## Placeholder View Helper

The @`Placeholder`[Zend\View\Helper\Placeholder] is another useful view helper allowing for capturing HTML 
content and storing it for later use. Thus, analogous to the @`Partial` 
view helper, it allows to compose your page of several pieces. 


For example, you can use the @`Placeholder`[Zend\View\Helper\Placeholder] view helper in pair with the @`Partial`
view helper to "decorate" the content of a view template with another view template. A useful 
practical application for this is layout "inheritance".


Put the following code in the *layout2.phtml* template file:
		  
~~~php
<?php $this->placeholder('content')->captureStart(); ?>

<div class="row">
    <div class="col-md-8">
    <?= $this->content; ?>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Ads</h3>
          </div>
          <div class="panel-body">
            <strong>Zend Framework 3 Book</strong>
            <p>Learn how to create modern web applications with PHP 
                and Zend Framework 3</p>            
            <a target="_blank" 
               href="https://github.com/olegkrivtsov/using-zend-framework-3-book">
               Learn More
            </a>
          </div>
        </div>
    </div>
</div>

<?php 
  $this->placeholder('content')->captureEnd(); 
  echo $this->partial('layout/layout', 
          ['content'=>$this->placeholder('content')]); 
?>
~~~

And than use bellow code into controller file to send data to `layout2` file
~~~php
/**
     * We override the parent class' onDispatch() method to
     * set an alternative layout for all actions in this controller.
     */
    public function onDispatch(MvcEvent $e)
    {
        // Call the base class' onDispatch() first and grab the response
        $response = parent::onDispatch($e);

        // Set alternative layout
        $this->layout()->setTemplate('layout/layout2');
        $layoutData = [
            'company' => 'XYZ Co.'
        ];
        $this->layout()->setVariables($layoutData);

        // Return the response
        return $response;
    }
~~~

---
# Adding Scripts to a Layout
---


Let say you want to add bellow code into footer of the layout.
~~~php
<script type="text/javascript">
  // Show a simple alert window with the "Hello World!" text.
  $(document).ready(function() { 
    alert('Hello World!');
  });
</script>
~~~


| *Method name*                  | *Description*                                                 |
|--------------------------------|---------------------------------------------------------------|
| `appendFile()`                 | Puts a link to external JS file after all others.             |
| `offsetSetFile()`              | Inserts a link to external JS file in a given list position.  |
| `prependFile()`                | Puts a link to external JS file before all others.            |
| `setFile()`                    | Clears the list of scripts and puts the single external JS file in it. |
| `appendScript()`               | Puts an inline script after all others.                       |
| `offsetSetScript()`            | Inserts an inline script to a given list position.            |
| `prependScript()`              | Puts an inline script before all others.                      |
| `setScript()`                  | Clears the list of inline scripts and puts the single inline  |
|                                | script in it.
---
# Foot Note
---

- I have gathered all the details from very different source  including [Using Zend Framework 3 by  olegkrivtsov by  ](https://olegkrivtsov.github.io/using-zend-framework-3-book/html/index.html), All the relevant content goes to respective writer.
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
