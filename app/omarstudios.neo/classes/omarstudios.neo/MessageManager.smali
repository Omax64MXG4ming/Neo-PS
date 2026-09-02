.class public Lomarstudios/neo/MessageManager;
.super Ljava/lang/Object;


# direct methods
.method public constructor <init>()V
    .registers 1

    invoke-direct {p0}, Ljava/lang/Object;-><init>()V

    return-void
.end method

.method public static check(Landroid/content/Context;)V
    .registers 2

    new-instance v0, Lomarstudios/neo/MessageTask;

    invoke-direct {v0, p0}, Lomarstudios/neo/MessageTask;-><init>(Landroid/content/Context;)V

    new-instance p0, Ljava/lang/Thread;

    invoke-direct {p0, v0}, Ljava/lang/Thread;-><init>(Ljava/lang/Runnable;)V

    invoke-virtual {p0}, Ljava/lang/Thread;->start()V

    return-void
.end method
