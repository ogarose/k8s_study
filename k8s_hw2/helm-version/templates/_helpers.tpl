{{/*
Create a default fully qualified app name.
We truncate at 63 chars because some Kubernetes name fields are limited to this (by the DNS naming spec).
If release name contains chart name it will be used as a full name.
*/}}
{{- define "helm-version.fullname" -}}
{{- if .Values.fullnameOverride }}
{{- .Values.fullnameOverride | trunc 63 | trimSuffix "-" }}
{{- else }}
{{- $name := default .Chart.Name .Values.nameOverride }}
{{- if contains $name .Release.Name }}
{{- .Release.Name | trunc 63 | trimSuffix "-" }}
{{- else }}
{{- printf "%s-%s" .Release.Name $name | trunc 63 | trimSuffix "-" }}
{{- end }}
{{- end }}
{{- end }}



{{- define "crudchart.dbenvs" -}}
- name: DB_HOST
  valueFrom:
    configMapKeyRef:
      name: {{ include "helm-version.fullname" . }}-configmap
      key: DB_HOST
- name: DB_PORT
  valueFrom:
    configMapKeyRef:
      name: {{ include "helm-version.fullname" . }}-configmap
      key: DB_PORT
- name: DB_NAME
  valueFrom:
    configMapKeyRef:
      name: {{ include "helm-version.fullname" . }}-configmap
      key: DB_NAME
- name: DB_USERNAME
  valueFrom:
    configMapKeyRef:
      name: {{ include "helm-version.fullname" . }}-configmap
      key: DB_USERNAME
- name: DB_PASSWORD
  valueFrom:
    secretKeyRef:
#                  the secret auto created by helm db install
      name: {{ .Values.db.passwordSecret.name }}
      key: {{ .Values.db.passwordSecret.key }}
{{- end }}

