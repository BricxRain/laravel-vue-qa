<template>
    <div class="media post">
        <div class="d-flex flex-column counters">
            <div class="vote">
                <strong>{{ question.vote_count }}</strong> {{ str_plural('vote', question.vote_count) }}
            </div>
            <div :class="statusClasses">
                <strong>{{ question.answer_count }}</strong> {{ str_plural('answer', question.answer_count) }}
            </div>
            <div class="view">
                {{ question.views + " " + str_plural('view', question.answer_count) }}
            </div>
        </div>
        <div class="media-body">
            <div class="d-flex align-items-center">
                <h3 class="mt-0"><a href="#">{{ question.title }}</a></h3>
                <div class="ml-auto">
                        
                    <a href="#" v-if="authorize('modify', question)" class="btn btn-sm btn-outline-info">Edit</a>
                    
                    <form v-if="authorize('deleteQuestion', question)" class="form-delete" action="#" method="POST">
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
            <p class="lead">
                Asked by
                <a href="#">{{ question.user.name }}</a>
                <small class="text-muted">{{ question.created_date }}</small>
            </p>
            <div class="excerpt">{{ question.excerpt }}</div>
        </div>
    </div>
</template>
<script>
export default {

    props: ['question'],
    
    computed: {
        statusClasses () {
            return [
                'status',
                this.question.status
            ];
        }
    },

    methods: {
        str_plural (str, count) {
            return str + (count > 1 ? 's' : '');
        }
    }
}
</script>