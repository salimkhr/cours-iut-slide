#  AJAX
## Asynchronous JavaScript and XML.

---

### Exemple
```JS [15-21|3-10|11|12]
function postData(url = "", data = {}) {
    // Default options are marked with *
    const response = fetch(url, {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer sk-******************************************"
        },
        body: JSON.stringify(data), // body data type must match "Content-Type" header
    })
        .then((response) => response.json())
        .then((data) => {document.getElementById('data').innerHTML = data.choices[0].message.content});
}

document.getElementById('loadData').addEventListener('click',function(){
    postData("https://api.openai.com/v1/chat/completions",
        {
            model: 'gpt-3.5-turbo',
            messages: [{"role": "user", "content": "What is the OpenAI mission?"}]
        }
    );
});
```
