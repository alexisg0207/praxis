# This is an auto-generated Django model module.
# You'll have to do the following manually to clean this up:
#   * Rearrange models' order
#   * Make sure each model has one field with primary_key=True
#   * Remove `managed = False` lines if you wish to allow Django to create, modify, and delete the table
# Feel free to rename the models, but don't rename db_table values or field names.
#
# Also note: You'll have to insert the output of 'django-admin sqlcustom [app_label]'
# into your database.
from __future__ import unicode_literals

from django.db import models


class Asignatura(models.Model):
    codigo = models.IntegerField(primary_key=True)
    nombre = models.IntegerField(blank=True, null=True)
    estudiante = models.ForeignKey('Estudiante', db_column='estudiante', blank=True, null=True)
    coordinador = models.ForeignKey('ProfesorCoordinador', db_column='coordinador', blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'asignatura'


class AuthGroup(models.Model):
    name = models.CharField(unique=True, max_length=80)

    class Meta:
        managed = False
        db_table = 'auth_group'


class AuthGroupPermissions(models.Model):
    group = models.ForeignKey(AuthGroup)
    permission = models.ForeignKey('AuthPermission')

    class Meta:
        managed = False
        db_table = 'auth_group_permissions'
        unique_together = (('group_id', 'permission_id'),)


class AuthPermission(models.Model):
    name = models.CharField(max_length=255)
    content_type = models.ForeignKey('DjangoContentType')
    codename = models.CharField(max_length=100)

    class Meta:
        managed = False
        db_table = 'auth_permission'
        unique_together = (('content_type_id', 'codename'),)


class AuthUser(models.Model):
    password = models.CharField(max_length=128)
    last_login = models.DateTimeField(blank=True, null=True)
    is_superuser = models.BooleanField()
    username = models.CharField(unique=True, max_length=30)
    first_name = models.CharField(max_length=30)
    last_name = models.CharField(max_length=30)
    email = models.CharField(max_length=254)
    is_staff = models.BooleanField()
    is_active = models.BooleanField()
    date_joined = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'auth_user'


class AuthUserGroups(models.Model):
    user = models.ForeignKey(AuthUser)
    group = models.ForeignKey(AuthGroup)

    class Meta:
        managed = False
        db_table = 'auth_user_groups'
        unique_together = (('user_id', 'group_id'),)


class AuthUserUserPermissions(models.Model):
    user = models.ForeignKey(AuthUser)
    permission = models.ForeignKey(AuthPermission)

    class Meta:
        managed = False
        db_table = 'auth_user_user_permissions'
        unique_together = (('user_id', 'permission_id'),)


class Cambios(models.Model):
    id = models.IntegerField(primary_key=True)
    convenio = models.ForeignKey('Convenio', db_column='convenio', blank=True, null=True)
    descripcion = models.CharField(max_length=-1, blank=True, null=True)
    fecha = models.DateField(blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'cambios'


class Control(models.Model):
    codigo = models.IntegerField(primary_key=True)
    descripcion = models.CharField(max_length=-1, blank=True, null=True)
    fecha = models.DateField(blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'control'


class Convenio(models.Model):
    id = models.IntegerField(primary_key=True)
    fecha_inicio = models.DateField(blank=True, null=True)
    fecha_fin = models.DateField(blank=True, null=True)
    documentacion = models.CharField(max_length=-1, blank=True, null=True)
    responsable = models.CharField(max_length=-1, blank=True, null=True)
    razon = models.CharField(max_length=-1, blank=True, null=True)
    practica_externa = models.IntegerField(blank=True, null=True)
    nit_empresa = models.ForeignKey('Empresa', db_column='nit_empresa', blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'convenio'


class Dependencia(models.Model):
    codigo = models.IntegerField(primary_key=True)
    nombre = models.IntegerField(blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'dependencia'


class Director(models.Model):
    codigo = models.IntegerField(primary_key=True)
    nombre = models.CharField(max_length=-1, blank=True, null=True)
    documento = models.IntegerField(blank=True, null=True)
    apellido = models.CharField(max_length=-1, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'director'


class DjangoAdminLog(models.Model):
    action_time = models.DateTimeField()
    object_id = models.TextField(blank=True, null=True)
    object_repr = models.CharField(max_length=200)
    action_flag = models.SmallIntegerField()
    change_message = models.TextField()
    content_type = models.ForeignKey('DjangoContentType', blank=True, null=True)
    user = models.ForeignKey(AuthUser)

    class Meta:
        managed = False
        db_table = 'django_admin_log'


class DjangoContentType(models.Model):
    app_label = models.CharField(max_length=100)
    model = models.CharField(max_length=100)

    class Meta:
        managed = False
        db_table = 'django_content_type'
        unique_together = (('app_label', 'model'),)


class DjangoMigrations(models.Model):
    app = models.CharField(max_length=255)
    name = models.CharField(max_length=255)
    applied = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'django_migrations'


class DjangoSession(models.Model):
    session_key = models.CharField(primary_key=True, max_length=40)
    session_data = models.TextField()
    expire_date = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'django_session'


class Empresa(models.Model):
    nit = models.CharField(primary_key=True, max_length=-1)
    nombre = models.CharField(max_length=-1, blank=True, null=True)
    localidad = models.IntegerField(blank=True, null=True)
    representante = models.IntegerField(blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'empresa'


class Estudiante(models.Model):
    codigo = models.IntegerField(primary_key=True)
    documento = models.IntegerField(blank=True, null=True)
    nombre = models.CharField(max_length=-1, blank=True, null=True)
    apellido = models.CharField(max_length=-1, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'estudiante'


class Localidad(models.Model):
    id = models.IntegerField(primary_key=True)
    nombre = models.CharField(max_length=-1, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'localidad'


class Practica(models.Model):
    id = models.IntegerField(primary_key=True)
    coordinador_docente = models.IntegerField(blank=True, null=True)
    estudiante = models.IntegerField(blank=True, null=True)
    coordinador_empresa = models.IntegerField(blank=True, null=True)
    valor = models.IntegerField(blank=True, null=True)
    fecha_inicio = models.DateField(blank=True, null=True)
    fecha_fin = models.DateField(blank=True, null=True)
    control = models.ForeignKey(Control, db_column='control', blank=True, null=True)
    asignatura = models.ForeignKey(Asignatura, db_column='asignatura', blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'practica'


class PracticaExterna(models.Model):
    id = models.IntegerField(primary_key=True)
    convenio = models.ForeignKey(Convenio, db_column='convenio', blank=True, null=True)
    localidad = models.ForeignKey(Localidad, db_column='localidad', blank=True, null=True)
    practica = models.ForeignKey(Practica, db_column='practica', blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'practica_externa'


class PracticaInterna(models.Model):
    id = models.IntegerField(primary_key=True)
    dependencia = models.ForeignKey(Dependencia, db_column='dependencia', blank=True, null=True)
    practica = models.ForeignKey(Practica, db_column='practica', blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'practica_interna'


class ProfesorCoordinador(models.Model):
    id = models.IntegerField(primary_key=True)
    nombre = models.CharField(max_length=-1, blank=True, null=True)
    documento = models.IntegerField(blank=True, null=True)
    apellido = models.CharField(max_length=-1, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'profesor_coordinador'


class Programa(models.Model):
    codigo = models.IntegerField(primary_key=True)
    nombre = models.IntegerField(blank=True, null=True)
    asignatura = models.ForeignKey(Asignatura, db_column='asignatura', blank=True, null=True)
    director = models.ForeignKey(Director, db_column='director', blank=True, null=True)
    control = models.IntegerField(blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'programa'


class Responsble(models.Model):
    id = models.IntegerField(primary_key=True)
    nombre = models.IntegerField(blank=True, null=True)
    nit_empresa = models.IntegerField(blank=True, null=True)
    empresa_nit = models.ForeignKey(Empresa, db_column='empresa_nit')
    apellido = models.CharField(max_length=-1, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'responsble'
