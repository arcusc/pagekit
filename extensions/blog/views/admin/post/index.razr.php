@script('blog.posts-index', 'blog/js/post/index.js', 'requirejs')

<form id="js-posts" class="uk-form" action="@url.route('@blog/post')" method="post">

    <div class="pk-toolbar uk-clearfix">
        <div class="uk-float-left">

            <a class="uk-button uk-button-primary" href="@url.route('@blog/post/add')">@trans('Add Post')</a>
            <a class="uk-button pk-button-danger uk-hidden js-show-on-select" href="#" data-action="@url.route('@blog/post/delete')">@trans('Delete')</a>

            <div class="uk-button-dropdown uk-hidden js-show-on-select" data-uk-dropdown="{ mode: 'click' }">
                <button class="uk-button" type="button">@trans('More') <i class="uk-icon-caret-down"></i></button>
                <div class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="#" data-action="@url.route('@blog/post/status', ['status' => 2])">@trans('Publish')</a></li>
                        <li><a href="#" data-action="@url.route('@blog/post/status', ['status' => 3])">@trans('Unpublish')</a></li>
                        <li class="uk-nav-divider"></li>
                        <li><a href="#" data-action="@url.route('@blog/post/copy')">@trans('Copy')</a></li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="uk-float-right uk-hidden-small">

            <select name="filter[status]">
                <option value="">@trans('- Status -')</option>
                @foreach (statuses as id => status)
                <option value="@id"@(filter['status']|length && filter['status'] == id ? ' selected')>@status</option>
                @endforeach
            </select>

            <input type="text" name="filter[search]" placeholder="@trans('Search')" value="@filter['search']">

        </div>
    </div>

    <p class="uk-alert uk-alert-info @(posts ? 'uk-hidden' : '')">@trans('No posts found.')</p>

    <div class="js-table uk-overflow-container">
        @include('view://blog/admin/post/table.razr.php', ['posts' => posts])
    </div>

    <ul class="uk-pagination @(total < 2 ? 'uk-hidden' : '')" data-uk-pagination="{ pages: @total }"></ul>

    @token()

    <input type="hidden" name="page" value="0">

</form>