@include('admin/header')
@foreach ($data as $key=> $item)
    <h3>{{$key+1}}、（{{$item['table_name']}}）{{$item['table_comment']}}</h3>
    <hr class="layui-bg-red">
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>字段名</th>
            <th>数据类型</th>
            <th>默认值</th>
            <th>可空</th>
            <th>自动递增</th>
            <th>备注</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($item['tables'] as $value )
            <tr>
                <td>{{$value['COLUMN_NAME']}}</td>
                <td>{{$value['COLUMN_TYPE']}}</td>
                <td>{{$value['COLUMN_DEFAULT']}}</td>
                <td>{{$value['IS_NULLABLE']}}</td>
                @if ($value['EXTRA']=='auto_increment')
                    <td>是</td>
                @else
                    <td></td>
                @endif
                <td>{{$value['COLUMN_COMMENT']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach