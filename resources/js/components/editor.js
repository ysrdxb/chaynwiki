import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Link from '@tiptap/extension-link'

document.addEventListener('alpine:init', () => {
    Alpine.data('richText', (content = '') => ({
        editor: null,
        content: content,
        updatedAt: Date.now(), // Force update watcher

        init() {
            this.editor = new Editor({
                element: this.$refs.editor,
                extensions: [
                    StarterKit.configure({
                        heading: {
                            levels: [2, 3],
                        },
                    }),
                    Link.configure({
                        openOnClick: false,
                        HTMLAttributes: {
                            class: 'text-brand-400 underline hover:text-brand-300 transition',
                        },
                    }),
                ],
                editorProps: {
                    attributes: {
                        class: 'prose prose-invert max-w-none focus:outline-none min-h-[300px] text-gray-200',
                    },
                },
                content: this.content,
                onUpdate: ({ editor }) => {
                    this.content = editor.getHTML()
                    this.$dispatch('input', this.content) // For Livewire
                },
            })

            // Watch for changes from Livewire (optional if one-way binding is sufficient)
            this.$watch('content', (newContent) => {
                if (this.editor && newContent !== this.editor.getHTML()) {
                    this.editor.commands.setContent(newContent, false)
                }
            })
        },

        toggleBold() { this.editor.chain().focus().toggleBold().run() },
        toggleItalic() { this.editor.chain().focus().toggleItalic().run() },
        toggleH2() { this.editor.chain().focus().toggleHeading({ level: 2 }).run() },
        toggleH3() { this.editor.chain().focus().toggleHeading({ level: 3 }).run() },
        toggleBulletList() { this.editor.chain().focus().toggleBulletList().run() },
    }))
})
