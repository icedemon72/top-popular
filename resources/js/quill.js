import Quill from 'quill';
// Or if you only need the core build
// import Quill from 'quill/core';

// import { Delta } from 'quill';
// // Or if you only need the core build
// // import { Delta } from 'quill/core';
// // Or const Delta = Quill.import('delta');

// import Link from 'quill/formats/link';
// // Or const Link = Quill.import('formats/link');

// const toolbarOptions = [
//   ['bold', 'italic', 'underline'],     
//   ['blockquote'],
//   [{ 'header': 1 }, { 'header': 2 }, { 'header': 3 }],            
//   [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
//   [{ 'script': 'sub'}, { 'script': 'super' }]
// ]

const quill = new Quill('#editor', {
  modules: {
    toolbar: true,
  },
  placeholder: 'Compose an epic...',
  theme:'snow'
});


quill.on('text-change', function(delta, source) {
  var justHtml = quill.root.innerHTML;
  document.getElementById('output-html').innerHTML = justHtml;
});