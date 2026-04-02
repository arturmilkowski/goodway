<script setup lang="ts">
import { watch, onBeforeUnmount } from 'vue';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import {
    BoldIcon,
    ItalicIcon,
    StrikethroughIcon,
    CodeIcon,
    Heading1Icon,
    Heading2Icon,
    Heading3Icon,
    ListIcon,
    ListOrderedIcon,
    ListChecksIcon,
    AlignLeftIcon,
    AlignCenterIcon,
    AlignRightIcon,
    QuoteIcon,
    MinusIcon,
    UndoIcon,
    RedoIcon,
} from 'lucide-vue-next';
import TextAlign from '@tiptap/extension-text-align';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';

const props = defineProps<{
    modelValue: string;
    class?: string;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit,
        TextAlign.configure({ types: ['heading', 'paragraph'] }),
    ],
    onUpdate({ editor }) {
        emit('update:modelValue', editor.getHTML());
    },
    editorProps: {
        attributes: {
            class: 'outline-none min-h-[160px] w-full text-sm p-3',
        },
    },
});

watch(
    () => props.modelValue,
    (value) => {
        if (editor.value && editor.value.getHTML() !== value) {
            editor.value.commands.setContent(value, false);
        }
    },
);

onBeforeUnmount(() => editor.value?.destroy());
</script>

<template>
    <div
        class="w-full rounded-md border border-input bg-background text-sm ring-offset-background focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2 focus-within:outline-none"
    >
        <!-- Pasek narzędzi -->
        <div
            v-if="editor"
            class="flex flex-wrap gap-0.5 border-b border-input p-1"
        >
            <!-- Historia -->
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                @click="editor.chain().focus().undo().run()"
                :disabled="!editor.can().undo()"
            >
                <UndoIcon class="h-4 w-4" />
            </Button>
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                @click="editor.chain().focus().redo().run()"
                :disabled="!editor.can().redo()"
            >
                <RedoIcon class="h-4 w-4" />
            </Button>

            <Separator orientation="vertical" class="mx-0.5 h-8" />

            <!-- Nagłówki -->
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{
                    'bg-accent': editor.isActive('heading', { level: 1 }),
                }"
                @click="
                    editor.chain().focus().toggleHeading({ level: 1 }).run()
                "
            >
                <Heading1Icon class="h-4 w-4" />
            </Button>
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{
                    'bg-accent': editor.isActive('heading', { level: 2 }),
                }"
                @click="
                    editor.chain().focus().toggleHeading({ level: 2 }).run()
                "
            >
                <Heading2Icon class="h-4 w-4" />
            </Button>
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{
                    'bg-accent': editor.isActive('heading', { level: 3 }),
                }"
                @click="
                    editor.chain().focus().toggleHeading({ level: 3 }).run()
                "
            >
                <Heading3Icon class="h-4 w-4" />
            </Button>

            <Separator orientation="vertical" class="mx-0.5 h-8" />

            <!-- Formatowanie tekstu -->
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{ 'bg-accent': editor.isActive('bold') }"
                @click="editor.chain().focus().toggleBold().run()"
            >
                <BoldIcon class="h-4 w-4" />
            </Button>
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{ 'bg-accent': editor.isActive('italic') }"
                @click="editor.chain().focus().toggleItalic().run()"
            >
                <ItalicIcon class="h-4 w-4" />
            </Button>
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{ 'bg-accent': editor.isActive('strike') }"
                @click="editor.chain().focus().toggleStrike().run()"
            >
                <StrikethroughIcon class="h-4 w-4" />
            </Button>
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{ 'bg-accent': editor.isActive('code') }"
                @click="editor.chain().focus().toggleCode().run()"
            >
                <CodeIcon class="h-4 w-4" />
            </Button>

            <Separator orientation="vertical" class="mx-0.5 h-8" />

            <!-- Listy -->
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{ 'bg-accent': editor.isActive('bulletList') }"
                @click="editor.chain().focus().toggleBulletList().run()"
            >
                <ListIcon class="h-4 w-4" />
            </Button>
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{ 'bg-accent': editor.isActive('orderedList') }"
                @click="editor.chain().focus().toggleOrderedList().run()"
            >
                <ListOrderedIcon class="h-4 w-4" />
            </Button>

            <Separator orientation="vertical" class="mx-0.5 h-8" />

            <!-- Wyrównanie -->
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{ 'bg-accent': editor.isActive({ textAlign: 'left' }) }"
                @click="editor.chain().focus().setTextAlign('left').run()"
            >
                <AlignLeftIcon class="h-4 w-4" />
            </Button>
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{
                    'bg-accent': editor.isActive({ textAlign: 'center' }),
                }"
                @click="editor.chain().focus().setTextAlign('center').run()"
            >
                <AlignCenterIcon class="h-4 w-4" />
            </Button>
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{
                    'bg-accent': editor.isActive({ textAlign: 'right' }),
                }"
                @click="editor.chain().focus().setTextAlign('right').run()"
            >
                <AlignRightIcon class="h-4 w-4" />
            </Button>

            <Separator orientation="vertical" class="mx-0.5 h-8" />

            <!-- Bloki -->
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                :class="{ 'bg-accent': editor.isActive('blockquote') }"
                @click="editor.chain().focus().toggleBlockquote().run()"
            >
                <QuoteIcon class="h-4 w-4" />
            </Button>
            <Button
                type="button"
                size="icon"
                variant="ghost"
                class="h-8 w-8"
                @click="editor.chain().focus().setHorizontalRule().run()"
            >
                <MinusIcon class="h-4 w-4" />
            </Button>
        </div>

        <!-- Obszar edycji -->
        <editor-content :editor="editor" @click="editor?.commands.focus()" />
    </div>
</template>

<style scoped>
:deep(.ProseMirror) {
    outline: none;
    min-height: 160px;
    width: 100%;
    padding: 0.75rem;
    font-size: 0.875rem;
}
:deep(.ProseMirror p) {
    line-height: 1.75;
}
:deep(.ProseMirror strong) {
    font-weight: 600;
}
:deep(.ProseMirror em) {
    font-style: italic;
}
:deep(.ProseMirror ul) {
    list-style-type: disc;
    padding-left: 1.5rem;
}
:deep(.ProseMirror ol) {
    list-style-type: decimal;
    padding-left: 1.5rem;
}
:deep(.ProseMirror h1) {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0.5rem 0;
}
:deep(.ProseMirror h2) {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0.5rem 0;
}
:deep(.ProseMirror h3) {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0.5rem 0;
}
:deep(.ProseMirror blockquote) {
    border-left: 4px solid hsl(var(--border));
    padding-left: 1rem;
    font-style: italic;
    color: hsl(var(--muted-foreground));
}
:deep(.ProseMirror code) {
    border-radius: 0.25rem;
    background-color: hsl(var(--muted));
    padding: 0.125rem 0.25rem;
    font-family: monospace;
    font-size: 0.75rem;
}
:deep(.ProseMirror pre) {
    border-radius: 0.375rem;
    background-color: hsl(var(--muted));
    padding: 1rem;
    font-family: monospace;
    font-size: 0.875rem;
}
:deep(.ProseMirror hr) {
    border: none;
    border-top: 1px solid hsl(var(--border));
    margin: 1rem 0;
}
:deep([style*='text-align: center']) {
    text-align: center;
}
:deep([style*='text-align: right']) {
    text-align: right;
}
:deep([style*='text-align: left']) {
    text-align: left;
}
</style>
