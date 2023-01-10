'use strict';

{
    const token = document.querySelector('main.todos').dataset.token;
    const input = document.querySelector('[name="title"]');
    const ul = document.querySelector('ul');
    input.focus();
    
    ul.addEventListener('click', e => {
        if(e.target.type === 'checkbox') {
            console.log("checkbox clicked" + e.target);
            fetch('?action=toggle', {
                method: 'POST',
                body: new URLSearchParams({
                //   id: e.target.parentNode.dataset.id,
                  id: e.target.parentNode.parentNode.dataset.id,
                  token: token,
                }),
            });
            console.log("change toggle!");
            // e.target.nextElementSibling.classList.toggle('done');
            e.target.parentNode.nextElementSibling.classList.toggle('done');
        }

        if(e.target.classList.contains('delete')) {
            if(!confirm('削除します。よろしいですか？')) {
                return;
            }
            fetch('?action=delete', {
                method: 'POST',
                body: new URLSearchParams({
                  id: e.target.parentNode.parentNode.dataset.id,
                  token: token,
                }),
            });
            console.log("testtest");
            e.target.parentNode.parentNode.remove();
        }

        if(e.target.classList.contains('edit-button-img')) {
            if(!confirm('編集画面に進みます。よろしいですか？')) {
                return;
            }
            e.target.parentNode.submit();
        }
    });

    function addTodo(id, titleValue) {
        console.log("token:" + token);
        const li = document.createElement('li');
        li.dataset.id = id;

        const label = document.createElement('label');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.classList.add("todo-check");
        const dummydiv = document.createElement('div');
        dummydiv.classList.add('DummyInput');
        label.appendChild(checkbox);
        label.appendChild(dummydiv);

        
        const title = document.createElement('span');
        title.textContent = titleValue;

        const tdiv = document.createElement('div');
        tdiv.classList.add('test');
        

        const editform = document.createElement('form');
        editform.action = "edit.php/?action=toedit";
        editform.method = "post";
        const formdiv = document.createElement('div');
        formdiv.classList.add('edit-button-img');
        const formcontent = document.createElement('input');
        formcontent.type = 'hidden';
        formcontent.name = 'content';
        formcontent.value = titleValue;
        const formid = document.createElement('input');
        formid.type = 'hidden';
        formid.name = 'id';
        formid.value = id;
        const formtoken = document.createElement('input');
        formtoken.type = 'hidden';
        formtoken.name = 'token';
        formtoken.value = token;

        const deletediv = document.createElement('div');
        deletediv.classList.add('delete');

        editform.appendChild(formdiv);
        editform.appendChild(formcontent);
        editform.appendChild(formid);
        editform.appendChild(formtoken);

        tdiv.appendChild(editform);
        tdiv.appendChild(deletediv);

        li.appendChild(label);
        li.appendChild(title);
        li.appendChild(tdiv);

        const ul = document.querySelector('ul');
        ul.insertBefore(li, ul.firstChild);
    }
    input.focus();
    document.querySelector('form.add').addEventListener('submit', e=> {
        e.preventDefault();
        console.log("token:" + token);
        const title = input.value;
        fetch('?action=add', {
            method: 'POST',
            body: new URLSearchParams({
              title: title,
              token: token,
            }),
          })
          .then(response => response.json())
          .then(json => {
            console.log(json.id);
            addTodo(json.id, title);
          });
          input.value = "";
          input.focus();
    });

    const titles = document.querySelectorAll('.title');
    titles.forEach(title => {
        title.addEventListener('dblclick', () => {
            // let input1 = document.createElement("input");
            // input1.setAttribute("type", "text");
            // input1.setAttribute("class", "title");
            // input1.setAttribute("name", "title");
            // input1.setAttribute("value", title.textContent.trim());
            // title.replaceWith(input1);
        });
    });
}