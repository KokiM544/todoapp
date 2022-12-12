'use strict';

{
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            checkbox.parentNode.submit();
        });
    });

    const deletes = document.querySelectorAll('.delete');
    deletes.forEach(span => {
        span.addEventListener('click', () => {
            if(!confirm('削除します。よろしいですか？')) {
                return;
            }
            span.parentNode.submit();
        });
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

    const editings = document.querySelectorAll('.edit-button-img');
    editings.forEach(div => {
        div.addEventListener('click', () => {
            if(!confirm('編集画面に進みます。よろしいですか？')) {
                return;
            }
            // location.href = "edit.php";
            div.parentNode.submit();
        });
    });
}