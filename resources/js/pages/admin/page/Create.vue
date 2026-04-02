<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, SendIcon } from 'lucide-vue-next';
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
import { index, create, store } from '@/routes/admin/pages';
import type { BreadcrumbItem } from '@/types';

const props = defineProps({ pages: Object });

const form = useForm<{
    parent_id: number | null;
    slug: string | null;
    title: string | number | undefined;
    intro: string | number | undefined;
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
    parent_id: null,
    slug: '',
    title: '',
    intro: '',
    content: '',
    img: '',
    img1: '',
    imgFile: null,
    imgFile1: null,
    site_description: '',
    site_keyword: '',
    navbar: true,
    hide: false,
    ordinal: 1,
});

function handleFileInput(event: Event) {
    const input = event.target as HTMLInputElement;
    form.imgFile = input.files?.[0] ?? null;
}
function handleFileInput1(event: Event) {
    const input = event.target as HTMLInputElement;
    form.imgFile1 = input.files?.[0] ?? null;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tworzenie podstrony',
        href: create().url,
    },
];
</script>

<template>
    <Head title="Tworzenie podstrony" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <pre>{{ form.errors }}</pre>
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border"
            >
                <form @submit.prevent="form.post(store().url)">
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
                                            <SelectLabel
                                                >Frameworki</SelectLabel
                                            >

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
                                <FieldLabel for="title">Nazwa</FieldLabel>
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
                            <Field>
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
                            <Field>
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
                                    Opis strony
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
                                <Link :href="index().url">
                                    <ArrowLeftIcon />
                                    Powrót
                                </Link>
                            </Button>
                            <Button type="submit" variant="outline">
                                <SendIcon />
                                Wyślij
                            </Button>
                        </ButtonGroup>
                    </FieldSet>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
