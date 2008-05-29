<table id="items" class="simple" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
		<th scope="col">ID</th>
		<th scope="col">Title</th>
		<th scope="col">Type</th>
		<th scope="col">Creator</th>
		<th scope="col">Date Added</th>
		<th scope="col">Public</th>
		<th scope="col">Featured</th>
		<th scope="col">Edit?</th>
		</tr>
	</thead>
	<tbody>
<?php while(loop_items()): ?>
<tr class="item<?php if($key%2==1) echo ' even'; else echo ' odd'; ?>">
	<td scope="row"><?php echo item('id');?></td> 
	<td><?php echo link_to_item(); ?></td>
	<td><?php echo item('Type Name'); ?></td>
	<td><?php echo item('Creator', 0); ?></td>	
	<td><?php echo date('m.d.Y', strtotime(item('Date Added'))); ?></td>
	<td><?php checkbox(array('name'=>"items[" . item('id') . "][public]",'class'=>"make-public"), item('public')); ?></td>
	<td><?php checkbox(array('name'=>"items[" . item('id') . "][featured]",'class'=>"make-featured"), item('featured')); ?>
		<?php hidden(array('name'=>"items[" . item('id') . "][id]"), item('id')); ?>
	</td>
	<td><?php echo link_to_item('edit', 'Edit', array('class'=>'edit')); ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>



