# Script para agregar MySQL al PATH del sistema
# Ejecutar como administrador

param(
    [string]$MySQLPath = "F:\xampp\mysql\bin"
)

Write-Host "Agregando MySQL al PATH del sistema..." -ForegroundColor Green

# Verificar si la ruta existe
if (-not (Test-Path $MySQLPath)) {
    Write-Host "Error: La ruta $MySQLPath no existe." -ForegroundColor Red
    exit 1
}

# Obtener el PATH actual del sistema
$currentPath = [Environment]::GetEnvironmentVariable("PATH", [EnvironmentVariableTarget]::Machine)

# Verificar si MySQL ya está en el PATH
if ($currentPath -like "*$MySQLPath*") {
    Write-Host "MySQL ya está en el PATH del sistema." -ForegroundColor Yellow
    exit 0
}

try {
    # Agregar MySQL al PATH del sistema
    $newPath = $currentPath + ";" + $MySQLPath
    [Environment]::SetEnvironmentVariable("PATH", $newPath, [EnvironmentVariableTarget]::Machine)
    
    Write-Host "MySQL agregado exitosamente al PATH del sistema." -ForegroundColor Green
    Write-Host "Reinicia la terminal para que los cambios surtan efecto." -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Ahora puedes usar comandos como:" -ForegroundColor White
    Write-Host "  mysql -u root -p" -ForegroundColor Yellow
    Write-Host "  mysqldump --version" -ForegroundColor Yellow
    
} catch {
    Write-Host "Error al agregar MySQL al PATH: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}