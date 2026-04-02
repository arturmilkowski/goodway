<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { ArrowLeftIcon, SendIcon, Trash2Icon } from 'lucide-vue-next';
import ImgController from '@/actions/App/Http/Controllers/Admin/Blog/Post/ImgController';
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
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { show, update, edit, destroy } from '@/routes/admin/blog/posts';
import type { BreadcrumbItem } from '@/types';

const props = defineProps({ post: Object, path: String });

const form = useForm<{
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
    approved: boolean;
    published: boolean;
    comments_allowed: boolean;
}>({
    slug: props.post?.slug,
    title: props.post?.title,
    intro: props.post?.intro,
    content: props.post?.content,
    img: props.post?.img,
    img1: props.post?.img1,
    imgFile: props.post?.imgFile,
    imgFile1: props.post?.imgFile1,
    site_description: props.post?.site_description,
    site_keyword: props.post?.site_keyword,
    approved: props.post?.approved,
    published: props.post?.published,
    comments_allowed: props.post?.comments_allowed,
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
        form.delete(destroy(props.post?.id).url);
    }
};

const destroyImg = (postId: number, imgId: number) => {
    if (confirm('Na pewno?')) {
        router.delete(ImgController(postId).url, {
            data: { img_id: imgId },
        });
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edycja wpisu',
        href: edit(props.post?.id).url,
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
                <form @submit.prevent="form.put(update(props.post?.id).url)">
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
                                    Wstęp do wpisu
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
                                    Zawartość wpisu
                                </FieldLabel>
                                <!-- <Textarea
                                    id="content"
                                    name="content"
                                    v-model="form.content"
                                    placeholder="Pole nieobowiązkowe"
                                >
                                </Textarea> -->
                                <Editor
                                    id="content"
                                    name="content"
                                    v-model="form.content"
                                    placeholder="Pole nieobowiązkowe"
                                >
                                </Editor>
                                <FieldError v-if="form.errors.content">
                                    {{ form.errors.content }}
                                </FieldError>
                            </Field>

                            <div v-if="post?.img">
                                <img :src="path + '/' + post.img" />
                                <Button
                                    type="button"
                                    variant="destructive"
                                    @click="destroyImg(post?.id, 1)"
                                >
                                    <Trash2Icon />
                                    Usuń grafikę 1
                                </Button>
                            </div>
                            <Field class="mb-6">
                                <FieldLabel for="img">Grafika 1</FieldLabel>
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

                            <div v-if="post?.img1">
                                <img :src="path + '/' + post.img1" />
                                <Button
                                    type="button"
                                    variant="destructive"
                                    @click="destroyImg(post?.id, 2)"
                                >
                                    <Trash2Icon />
                                    Usuń grafikę 2
                                </Button>
                            </div>
                            <Field class="mb-6">
                                <FieldLabel for="img1">Grafika 2</FieldLabel>
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
                                        id="published"
                                        name="published"
                                        v-model="form.published"
                                    />
                                    <FieldLabel for="published">
                                        Opublikowano
                                    </FieldLabel>
                                </div>
                            </Field>
                            <Field>
                                <div class="flex items-center gap-3">
                                    <Checkbox
                                        id="comments_allowed"
                                        name="comments_allowed"
                                        v-model="form.comments_allowed"
                                    />
                                    <FieldLabel for="comments_allowed">
                                        Komentarze dozwolone
                                    </FieldLabel>
                                </div>
                            </Field>
                        </FieldGroup>
                        <ButtonGroup>
                            <Button variant="outline" as-child>
                                <Link :href="show(post?.id).url">
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
