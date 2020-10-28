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
$entry->setTitle('SOLID Principles');
$entry->setAuthor($author);
$entry->setDraft(false);
$entry->setPublic(true);
$entry->setCreated(new DateTime('2019:08:20 16:33:48'));
$entry->setUpdated(new DateTime('2019:08:20 16:35:03'));
$entry->setTimezone('Asia/Kolkata');
$entry->setTags(['php','principles']);

$body = <<<'EOT'
In object-oriented computer programming, SOLID is a mnemonic acronym for five design principles intended to make software designs more understandable, flexible and maintainable.

S.O.L.I.D. STANDS FOR:

~~~ 
    S — Single responsibility principle.
    O — Open closed principle.
    L — Liskov substitution principle.
    I — Interface segregation principle.
    D — Dependency Inversion principle.

~~~
EOT;
$entry->setBody(convertMarkdownToHtml($body));
$extended = <<<'EOT'

### S — Single responsibility principle

In programming, the Single Responsibility Principle states that every module or class should have responsibility over a single part of the functionality provided by the software.
You may have heard the quote: 

> “Do one thing and do it well”.

This refers to the single responsibility principle.
In the article Principles of Object Oriented Design, Robert C. Martin defines a responsibility as a ‘reason to change’, and concludes that a class or module should have one, and only one, reason to be changed.

### O — Open/closed principle

In programming, the open/closed principle states that software entities (classes, modules, functions, etc.) should be open for extensions, but closed for modification.
If you have a general understanding of OOP, you probably already know about polymorphism. We can make sure that our code is compliant with the open/closed principle by utilizing inheritance and/or implementing interfaces that enable classes to polymorphically substitute for each other.


### L — Liskov substitution principle

This one is probably the hardest one to wrap your head around when being introduced for the first time.

In programming, the Liskov substitution principle states that if S is a subtype of T, then objects of type T may be replaced (or substituted) with objects of type S.

This can be formulated mathematically as

Let ϕ(x) be a property provable about objects x of type T.

Then ϕ(y) should be true for objects y of type S, where S is a subtype of T.

More generally it states that objects in a program should be replaceable with instances of their subtypes without altering the correctness of that program.

### I — Interface segregation principle

This principle is fairly easy to comprehend.
In fact, if you’re used to using interfaces, chances are that you’re already applying this principle.

If not, it’s time to start doing it!
In programming, the interface segregation principle states that no client should be forced to depend on methods it does not use.
Put more simply: Do not add additional functionality to an existing interface by adding new methods.

Instead, create a new interface and let your class implement multiple interfaces if needed.


### D - Dependency inversion principle

Finally, we got to D, the last of the 5 principles.
In programming, the dependency inversion principle is a way to decouple software modules.

This principle states that
High-level modules should not depend on low-level modules. Both should depend on abstractions.

Abstractions should not depend on details. Details should depend on abstractions.

To comply with this principle, we need to use a design pattern known as a dependency inversion pattern, most often solved by using dependency injection.
Dependency injection is a huge topic and can be as complicated or simple as one might see the need for.
Typically, dependency injection is used simply by ‘injecting’ any dependencies of a class through the class’ constructor as an input parameter.
EOT;


$entry->setExtended(convertMarkdownToHtml($extended));

return $entry;
