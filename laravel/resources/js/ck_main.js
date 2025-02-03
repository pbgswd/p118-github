import {
    ClassicEditor,Alignment,AccessibilityHelp,Autoformat,Autosave,BlockQuote,Bold,Essentials,
    FullPage,GeneralHtmlSupport,Heading,HorizontalLine,HtmlComment,HtmlEmbed,Indent,IndentBlock,Italic,
    Link,List,ListProperties,MediaEmbed,Paragraph,PasteFromOffice,SelectAll,ShowBlocks,
    SourceEditing,Table,TableCaption,TableCellProperties,TableColumnResize,TableProperties,
    TableToolbar,TextTransformation,TodoList,Underline,Undo
} from './ckeditor5/ckeditor5';

const editorConfig = {
    toolbar: {
        items: [
            'undo',	'redo',	'|', 'sourceEditing','showBlocks','|',
            'heading','|','bold','italic','underline','|',
            'link','mediaEmbed','insertTable','blockQuote','htmlEmbed','|',
            'alignment', 'horizontalLine', 'bulletedList',	'numberedList','todoList','outdent','indent'
        ],
        shouldNotGroupWhenFull: false
    },
    plugins: [
        AccessibilityHelp,
        Alignment,
        Autoformat,
        Autosave,
        BlockQuote,
        Bold,
        Essentials,
        FullPage,
        GeneralHtmlSupport,
        Heading,
        HorizontalLine,
        HtmlComment,
        HtmlEmbed,
        Indent,
        IndentBlock,
        Italic,
        Link,
        List,
        ListProperties,
        MediaEmbed,
        Paragraph,
        PasteFromOffice,
        SelectAll,
        ShowBlocks,
        SourceEditing,
        Table,
        TableCaption,
        TableCellProperties,
        TableColumnResize,
        TableProperties,
        TableToolbar,
        TextTransformation,
        TodoList,
        Underline,
        Undo
    ],
    heading: {
        options: [
            {
                model: 'paragraph',
                title: 'Paragraph',
                class: 'ck-heading_paragraph'
            },
            {
                model: 'heading1',
                view: 'h1',
                title: 'Heading 1',
                class: 'ck-heading_heading1'
            },
            {
                model: 'heading2',
                view: 'h2',
                title: 'Heading 2',
                class: 'ck-heading_heading2'
            },
            {
                model: 'heading3',
                view: 'h3',
                title: 'Heading 3',
                class: 'ck-heading_heading3'
            },
            {
                model: 'heading4',
                view: 'h4',
                title: 'Heading 4',
                class: 'ck-heading_heading4'
            },
            {
                model: 'heading5',
                view: 'h5',
                title: 'Heading 5',
                class: 'ck-heading_heading5'
            },
            {
                model: 'heading6',
                view: 'h6',
                title: 'Heading 6',
                class: 'ck-heading_heading6'
            }
        ]
    },
    htmlSupport: {
        allow: [
            {
                name: /^.*$/,
                styles: true,
                attributes: true,
                classes: true
            }
        ]
    },
    initialData:
        textarea,
    link: {
        addTargetToExternalLinks: true,
        defaultProtocol: 'https://',
        decorators: {
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },
    placeholder: 'Type or paste your content here!',
    table: {
        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
    }
};

ClassicEditor.create(document.querySelector('#textarea'), editorConfig);
