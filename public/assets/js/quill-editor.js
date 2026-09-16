(function () {
    "use strict";
    
    if (typeof ImageResize !== 'undefined') {
        Quill.register('modules/imageResize', ImageResize.default || ImageResize);
    }
    /* quill snow editor */
    var toolbarOptions = [
        [{ header: [1, 2, 3, 4, 5, 6, false] }],
        [{ font: [] }],
        ["bold", "italic", "underline", "strike"], // toggled buttons
        ["blockquote", "code-block"],

        [{ header: 1 }, { header: 2 }], // custom button values
        [{ list: "ordered" }, { list: "bullet" }],
        [{ script: "sub" }, { script: "super" }], // superscript/subscript
        [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
        [{ direction: "rtl" }], // text direction

        [{ size: ["small", false, "large", "huge"] }], // custom dropdown

        [{ color: [] }, { background: [] }], // dropdown with defaults from theme
        [{ align: [] }],

        ["link", "image", "video"],
        ["clean"], // remove formatting button
    ];
    var quill = new Quill("#editor", {
        modules: {
            toolbar: toolbarOptions,
            imageResize: {
                displaySize: true
            },
        },
        theme: "snow",
    });

    /* Isi quill -> textarea content news */
    const form = document.getElementById("newsForm");
    const content = document.getElementById("content");

    if (form && content) {
        form.addEventListener("submit", function (event) {
            const text = quill.getText().trim();

            if (!text) {
                content.value = '';
            } else {
                content.value = quill.root.innerHTML;
            }

        });
    }

    // Isi quill -> textarea jawaban FAQ
    const formFAQ = document.getElementById("faqForm");
    const jawaban = document.getElementById("jawaban");

    if (formFAQ && jawaban) {
        formFAQ.addEventListener("submit", function () {
            const textJawaban = quill.getText().trim();

            if (!textJawaban) {
                jawaban.value = '';
            } else {
                jawaban.value = quill.root.innerHTML;
            }
        });
    }
    
})();