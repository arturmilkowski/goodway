<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { ArrowLeftIcon, SendIcon, Trash2Icon } from 'lucide-vue-next';
import ImgController from '@/actions/App/Http/Controllers/Admin/Project/ImgController';
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
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { show, update, edit, destroy } from '@/routes/admin/projects';
import type { BreadcrumbItem } from '@/types';

const props = defineProps({ project: Object, path: String });

const form = useForm<{
    slug: string | null;
    title: string | number | undefined;
    intro: string;
    content: string;
    result: string;
    img: string | null;
    img1: string | null;
    imgFile: File | null;
    imgFile1: File | null;
    site_description: string;
    site_keyword: string;
    approved: boolean;
    hide: boolean;
}>({
    slug: props.project?.slug,
    title: props.project?.title,
    intro: props.project?.intro,
    content: props.project?.content,
    result: props.project?.result,
    img: props.project?.img,
    img1: props.project?.img1,
    imgFile: props.project?.imgFile,
    imgFile1: props.project?.imgFile1,
    site_description: props.project?.site_description,
    site_keyword: props.project?.site_keyword,
    approved: props.project?.approved,
    hide: props.project?.hide,
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
        form.delete(destroy(props.project?.id).url);
    }
};

const destroyImg = (projectId: number, imgId: number) => {
    if (confirm('Na pewno?')) {
        router.delete(ImgController(projectId).url, {
            data: { img_id: imgId },
        });
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edycja projektu',
        href: edit(props.project?.id).url,
    },
];
</script>

<template>
    <Head title="Edycja wpisu" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border"
            >
                <form @submit.prevent="form.put(update(props.project?.id).url)">
                    <FieldSet>
                        <FieldGroup>
                            <Field>
                                <FieldLabel for="title">Tytuł</FieldLabel>
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
                                    Wstęp do projektu
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
                                <FieldLabel for="content"> Cel </FieldLabel>
                                <Textarea
                                    id="content"
                                    name="content"
                                    v-model="form.content"
                                    placeholder="Pole nieobowiązkowe"
                                >
                                </Textarea>
                                <FieldError v-if="form.errors.content">
                                    {{ form.errors.content }}
                                </FieldError>
                            </Field>
                            <Field>
                                <FieldLabel for="result">Rezultat</FieldLabel>
                                <Textarea
                                    id="result"
                                    name="result"
                                    v-model="form.result"
                                    placeholder="Pole nieobowiązkowe"
                                >
                                </Textarea>
                                <FieldError v-if="form.errors.result">
                                    {{ form.errors.result }}
                                </FieldError>
                            </Field>
                            <div v-if="project?.img">
                                <img :src="path + '/' + project.img" />
                                <Button
                                    type="button"
                                    variant="destructive"
                                    @click="destroyImg(project?.id, 1)"
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
                            <div v-if="project?.img1">
                                <img :src="path + '/' + project.img1" />
                                <Button
                                    type="button"
                                    variant="destructive"
                                    @click="destroyImg(project?.id, 2)"
                                >
                                    <Trash2Icon />
                                    Usuń grafikę 2
                                </Button>
                            </div>
                            <Field class="mb-6">
                                <FieldLabel for="imgFile1">
                                    Grafika 2
                                </FieldLabel>
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
                                    Słowa kluczowe
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
                                        id="approved"
                                        name="approved"
                                        v-model="form.approved"
                                    />
                                    <FieldLabel for="approved">
                                        Zaakceptowano
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
                                    <FieldLabel for="hide">Ukryj</FieldLabel>
                                </div>
                            </Field>
                        </FieldGroup>
                        <ButtonGroup>
                            <Button variant="outline" as-child>
                                <Link :href="show(project?.id).url">
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
