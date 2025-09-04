### Les prototypes
```javascript [1-4|5-7|8-11|13-16]
function Employee(name, jobTitle) {
  Person.call(this, name)
  this.jobTitle = jobTitle
}

Employee.prototype = Object.create(Person.prototype)
Employee.prototype.constructor = Employee

Employee.prototype.sayJob = function() {
  console.log("I am a " + this.jobTitle)
};

let employee = new Employee("Jane", "Developer");
employee.sayHello() // affiche "Hello, my name is Jane"
employee.sayJob() // affiche "I am a Developer"
```
---
### Les prototypes
```javascript [1-3|4-7|8-10]
function Person(name) {
  this.name = name
}

Person.prototype.sayHello = function() {
  console.log("Hello, my name is " + this.name)
};

let person = new Person("John")
person.sayHello() // affiche "Hello, my name is John"
```