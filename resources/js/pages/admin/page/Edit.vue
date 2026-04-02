<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { ArrowLeftIcon, SendIcon, Trash2Icon } from 'lucide-vue-next';
import ImgController from '@/actions/App/Http/Controllers/Admin/Page/ImgController';
import Editor from '@/components/Editor.vue';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { Checkbox } from '@/components/ui/checkbox';
import {
    Field,
    FieldGroup,
    FieldLabel,
    FieldError,
    FieldSet,
} from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput,
} from '@/components/ui/number-field';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
    SelectLabel,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { show, update, edit, destroy } from '@/routes/admin/pages';
import type { BreadcrumbItem } from '@/types';

const props = defineProps({ page: Object, pages: Object, path: String });

const form = useForm<{
    parent_id: string | null;
    slug: string | null;
    title: string | number | undefined;
    intro: string;
    content: string;
    img: string | null;
    img1: string | null;
    imgFile: File | null;
    imgFile1: File | null;
    site_description: string;
    site_keyword: string;
    navbar: boolean;
    hide: boolean;
    ordinal: number;
}>({
    parent_id: props.page?.parent_id,
    slug: props.page?.slug,
    title: props.page?.title,
    intro: props.page?.intro,
    content: props.page?.content,
    img: props.page?.img,
    img1: props.page?.img1,
    imgFile: props.page?.imgFile,
    imgFile1: props.page?.imgFile1,
    site_description: props.page?.site_description,
    site_keyword: props.page?.site_keyword,
    navbar: props.page?.navbar,
    hide: props.page?.hide,
    ordinal: props.page?.ordinal ?? 1,
});

function handleFileInput(event: Event) {
    const input = event.target as HTMLInputElement;
    form.imgFile = input.files?.[0] ?? null;
}
function handleFileInput1(event: Event) {
    const input = event.target as HTMLInputElement;
    form.imgFile1 = input.files?.[0] ?? null;
}

const destroy_ = () => {
    if (confirm('Na pewno?')) {
        form.delete(destroy(props.page?.id).url);
    }
};

const destroyImg = (pageId: number, imgId: number) => {
    if (confirm('Na pewno?')) {
        router.delete(ImgController(pageId).url, {
            data: { img_id: imgId },
        });
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edycja podstrony',
        href: edit(props.page?.id).url,
    },
];
</script>

<template>
    <Head title="Edycja podstrony" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border"
            >
                <pre>__{{ form.parent_id }}__</pre>
                <form @submit.prevent="form.put(update(props.page?.id).url)">
                    <FieldSet>
                        <FieldGroup>
                            <Field>
                                <FieldLabel for="parent_id">
                                    Strona &mdash; rodzic
                                </FieldLabel>
                                <Select v-model="form.parent_id">
                                    <SelectTrigger class="w-[200px]">
                                        <SelectValue
                                            placeholder="Wybierz stronę - rodzica lub pozostaw puste gdy podstrona nie ma rodzica"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>
                                                Frameworki
                                            </SelectLabel>
                                            <SelectItem
                                                v-for="page in props.pages"
                                                :key="page.id"
                                                :value="page.id"
                                            >
                                                {{ page.title }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </Field>
                            <Field>
                                <FieldLabel for="title">
                                    Tytuł (nazwa) podstrony
                                </FieldLabel>
                                <Input
                                    id="title"
                                    name="title"
                                    type="text"
                                    v-model="form.title"
                                    placeholder="Pole obowiązkowe"
                                />
                                <FieldError v-if="form.errors.title">
                                    {{ form.errors.title }}
                                </FieldError>
                            </Field>
                            <Field>
                                <FieldLabel for="intro">
                                    Wstęp do podstrony
                                </FieldLabel>
                                <Textarea
                                    id="intro"
                                    name="intro"
                                    v-model="form.intro"
                                    placeholder="Pole nieobowiązkowe"
                                >
                                </Textarea>
                                <FieldError v-if="form.errors.intro">
                                    {{ form.errors.intro }}
                                </FieldError>
                            </Field>
                            <Field>
                                <FieldLabel for="content">
                                    Zawartość podstrony
                                </FieldLabel>
                                <Editor
                                    id="content"
                                    name="content"
                                    v-model="form.content"
                                    placeholder="Pole nieobowiązkowe"
                                >
                                </Editor>
                                <!--
                                <Textarea
                                    id="content"
                                    name="content"
                                    v-model="form.content"
                                    placeholder="Pole nieobowiązkowe"
                                >
                                </Textarea>
                                -->
                                <FieldError v-if="form.errors.content">
                                    {{ form.errors.content }}
                                </FieldError>
                            </Field>
                            <div v-if="page?.img">
                                <img :src="path + '/' + page.img" />
                                <Button
                                    type="button"
                                    variant="destructive"
                                    @click="destroyImg(page?.id, 1)"
                                >
                                    <Trash2Icon />
                                    Usuń grafikę 1
                                </Button>
                            </div>
                            <Field class="mb-6">
                                <FieldLabel for="imgFile">Grafika 1</FieldLabel>
                                <Input
                                    id="imgFile"
                                    name="imgFile"
                                    type="file"
                                    @input="handleFileInput"
                                    placeholder="Pole nieobowiązkowe"
                                />
                                <FieldError v-if="form.errors.imgFile">
                                    {{ form.errors.imgFile }}
                                </FieldError>
                                <progress
                                    v-if="form.progress"
                                    :value="form.progress.percentage"
                                    max="100"
                                >
                                    {{ form.progress.percentage }}%
                                </progress>
                            </Field>
                            <div v-if="page?.img1">
                                <img :src="path + '/' + page.img1" />
                                <Button
                                    type="button"
                                    variant="destructive"
                                    @click="destroyImg(page?.id, 2)"
                                >
                                    <Trash2Icon />
                                    Usuń grafikę 2
                                </Button>
                            </div>
                            <Field class="mb-6">
                                <FieldLabel for="imgFile1"
                                    >Grafika 2</FieldLabel
                                >
                                <Input
                                    id="imgFile1"
                                    name="imgFile1"
                                    type="file"
                                    @input="handleFileInput1"
                                    placeholder="Pole nieobowiązkowe"
                                />
                                <FieldError v-if="form.errors.imgFile1">
                                    {{ form.errors.imgFile1 }}
                                </FieldError>
                                <progress
                                    v-if="form.progress"
                                    :value="form.progress.percentage"
                                    max="100"
                                >
                                    {{ form.progress.percentage }}%
                                </progress>
                            </Field>
                            <Field>
                                <FieldLabel for="site_description">
                                    Opis podstrony
                                </FieldLabel>
                                <Input
                                    id="site_description"
                                    name="site_description"
                                    type="text"
                                    v-model="form.site_description"
                                    placeholder="Pole nieobowiązkowe"
                                />
                                <FieldError v-if="form.errors.site_description">
                                    {{ form.errors.site_description }}
                                </FieldError>
                            </Field>
                            <Field>
                                <FieldLabel for="site_keyword">
                                    Słowa kluczowe podstrony
                                </FieldLabel>
                                <Input
                                    id="site_keyword"
                                    name="site_keyword"
                                    type="text"
                                    v-model="form.site_keyword"
                                    placeholder="Pole nieobowiązkowe"
                                />
                                <FieldError v-if="form.errors.site_keyword">
                                    {{ form.errors.site_keyword }}
                                </FieldError>
                            </Field>
                            <Field>
                                <div class="flex items-center gap-3">
                                    <Checkbox
                                        id="navbar"
                                        name="navbar"
                                        v-model="form.navbar"
                                    />
                                    <FieldLabel for="navbar">
                                        Umieść w menu głównym
                                    </FieldLabel>
                                </div>
                            </Field>
                            <Field>
                                <div class="flex items-center gap-3">
                                    <Checkbox
                                        id="hide"
                                        name="hide"
                                        v-model="form.hide"
                                    />
                                    <FieldLabel for="hide">
                                        Ukryj podstronę
                                    </FieldLabel>
                                </div>
                            </Field>
                            <Field>
                                <FieldLabel for="ordinal">
                                    Kolejność
                                </FieldLabel>
                                <NumberField
                                    id="ordinal"
                                    name="ordinal"
                                    v-model="form.ordinal"
                                    min="1"
                                    max="99"
                                    step="1"
                                >
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput placeholder="1" />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                                <FieldError v-if="form.errors.ordinal">
                                    {{ form.errors.ordinal }}
                                </FieldError>
                            </Field>
                        </FieldGroup>
                        <ButtonGroup>
                            <Button variant="outline" as-child>
                                <Link :href="show(page?.id).url">
                                    <ArrowLeftIcon />
                                    Powrót
                                </Link>
                            </Button>
                            <Button type="submit" variant="outline">
                                <SendIcon />
                                Wyślij
                            </Button>
                            <Button
                                type="button"
                                variant="destructive"
                                @click="destroy_"
                            >
                                <Trash2Icon />
                                Usuń
                            </Button>
                        </ButtonGroup>
                    </FieldSet>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
