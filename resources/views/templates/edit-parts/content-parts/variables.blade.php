<style>
    .variables-container {
        @media (min-width: 768px) {
            border-left: 1px solid #e0e0e0;
        }
    }

    .variables td {
        padding: 4px;
        vertical-align: middle;
    }
</style>

<div>
    <h4>Variables</h4>

    <table class="variables">
        @foreach($template->templatable()
                          ->variableOperations(true)
                          ->flatMap(fn($variableOperation) => $variableOperation->variables())
                           as /** @var $variable App\Models\Template\Variable */ $variable)
            <tr>
                <td>{{ $variable->label }}</td>
                <td>
                    <button class="btn btn-default btn-icon btn-pure"
                        onclick="navigator.clipboard.writeText('{{ $variable->placeholderCode() }}')">
                        <i class="fa-solid fa-copy"></i>
                    </button>
                </td>
                <td class="text-nowrap"><code>{{ $variable->placeholderCode() }}</code></td>
            </tr>
        @endforeach
    </table>
</div>