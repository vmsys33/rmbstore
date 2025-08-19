# Development Memories

## Variable Names and Field Mapping
- Always verify variable names and field mappings when working with database data and JavaScript integration
- Common issues include: PHP array keys vs JavaScript object properties, database column names vs frontend field names
- When copying code between files, carefully check and adapt all variable references
- Use console.log() to verify data structure matches expectations
- Double-check section names in CodeIgniter views (e.g., 'scripts' vs 'custom_scripts')

## Previous Issues Resolved
- Section name mismatch in CodeIgniter layout: 'scripts' vs 'custom_scripts' prevented JavaScript from loading
- Variable name adaptations needed when copying from test.html to pos_interface.php (product.name → product.product_name)
- Database field mappings: ensure PHP json_encode output matches JavaScript expectations

## Best Practices
- Test data structure with console.log() before implementing functionality
- Use consistent naming conventions across PHP and JavaScript
- Verify all field mappings when integrating database data with frontend
- Check CodeIgniter view section names match layout expectations
